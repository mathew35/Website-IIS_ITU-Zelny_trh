<?php
echo "admin";
include "$_SERVER[DOCUMENT_ROOT]" . '/IIS_ITU-Zelny_trh/app/classes/mod.php';
include "$_SERVER[DOCUMENT_ROOT]" . '/IIS_ITU-Zelny_trh/app/classes/Non-registeredUser.php';
class Admin extends mod
{
    public function createMod()
    {
        // TODO
        echo "Creating mod ...\n";
    }
    public function addUser()
    {
        // TODO
        echo "Adding user ...\n";
    }
    public function removeUser()
    {
        // TODO
        echo "Removing user ...\n";
    }
}
