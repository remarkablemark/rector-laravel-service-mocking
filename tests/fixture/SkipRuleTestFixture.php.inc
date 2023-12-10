<?php

namespace Package\Tests\Rector\MyFirstRector\Fixture;

class SomeClass
{
    public function handleLogin(User $user, string $password)
    {
        return $user->isCorrectPassword($password);
    }
}

?>
