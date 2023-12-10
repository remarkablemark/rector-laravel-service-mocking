<?php

namespace Package\Tests\Rector\MyFirstRector\Fixture;

class SomeClass
{
    public function handlePasswordChange(User $user, string $password)
    {
        $user->setPassword($password);
    }
}

?>
-----
<?php

namespace Package\Tests\Rector\MyFirstRector\Fixture;

class SomeClass
{
    public function handlePasswordChange(User $user, string $password)
    {
        $user->changePassword($password);
    }
}

?>
