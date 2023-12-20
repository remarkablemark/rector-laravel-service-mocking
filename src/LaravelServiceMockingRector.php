<?php

declare(strict_types=1);

namespace Remarkablemark\RectorLaravelServiceMocking;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class LaravelServiceMockingRector extends AbstractRector
{
    /** @var BetterNodeFinder */
    protected $betterNodeFinder;

    public function __construct(BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace deprecated Laravel service mocking testing methods such as `expectsEvents`, `expectsJobs`, and `expectsNotifications`',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        class SomeClassTest
                        {
                            public function testExpectsEvents(): void
                            {
                                $this->expectsEvents([EventA::class, EventB::class]);
                            }

                            public function testExpectsJobs(): void
                            {
                                $this->expectsJobs([Job::class]);
                            }

                            public function testExpectsNotification(): void
                            {
                                $this->expectsNotification([
                                    NotificationA::class,
                                    NotificationB::class,
                                ]);
                            }
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        class SomeClassTest
                        {
                            public function testExpectsEvents(): void
                            {
                                \Illuminate\Support\Facades\Event::fake([EventA::class, EventB::class])->assertDispatched([EventA::class, EventB::class]);
                            }

                            public function testExpectsJobs(): void
                            {
                                \Illuminate\Support\Facades\Bus::fake([Job::class])->assertDispatched([Job::class]);
                            }

                            public function testExpectsNotification(): void
                            {
                                \Illuminate\Support\Facades\Notification::fake([
                                    NotificationA::class,
                                    NotificationB::class,
                                ])->assertSentTo([
                                    NotificationA::class,
                                    NotificationB::class,
                                ]);
                            }
                        }
                        CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        $subNodes = $this->betterNodeFinder->findInstanceOf($node, MethodCall::class);

        if (!$subNodes) {
            return null;
        }

        $hasChanged = false;

        foreach ($subNodes as $subNode) {
            $variableName = $this->getName($subNode->var);

            if ('this' !== $variableName) {
                continue;
            }

            $methodName = $this->getName($subNode->name);

            switch ($methodName) {
                case 'expectsEvents':
                    $subNode->var = new StaticCall(
                        new FullyQualified('Illuminate\Support\Facades\Event'),
                        'fake',
                        $subNode->args
                    );
                    $subNode->name = new Identifier('assertDispatched');
                    $hasChanged = true;

                    break;

                case 'doesntExpectEvents':
                    $subNode->var = new StaticCall(
                        new FullyQualified('Illuminate\Support\Facades\Event'),
                        'fake',
                        $subNode->args
                    );
                    $subNode->name = new Identifier('assertNotDispatched');
                    $hasChanged = true;

                    break;

                case 'expectsJobs':
                    $subNode->var = new StaticCall(
                        new FullyQualified('Illuminate\Support\Facades\Bus'),
                        'fake',
                        $subNode->args
                    );
                    $subNode->name = new Identifier('assertDispatched');
                    $hasChanged = true;

                    break;

                case 'doesntExpectJobs':
                    $subNode->var = new StaticCall(
                        new FullyQualified('Illuminate\Support\Facades\Bus'),
                        'fake',
                        $subNode->args
                    );
                    $subNode->name = new Identifier('assertNotDispatched');
                    $hasChanged = true;

                    break;

                case 'expectsNotification':
                    $subNode->var = new StaticCall(
                        new FullyQualified('Illuminate\Support\Facades\Notification'),
                        'fake',
                        $subNode->args
                    );
                    $subNode->name = new Identifier('assertSentTo');
                    $hasChanged = true;

                    break;

                default:
                    break;
            }
        }

        if ($hasChanged) {
            return $node;
        }

        return null;
    }
}
