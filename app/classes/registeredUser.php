<?PHP
include 'Non-registeredUser.php';
class registeredUser extends nonregisteredUser
{
    public $name = '';
    public $farmer = false;
    public $customer = false;
    public function __construct($val)
    {
        $this->name = $val;
        $this->farmer = false;
        $this->customer = false;
    }
    public function offerProduct()
    {
        //TODO
        $this->farmer = true;
    }
    public function orderProduct()
    {
        //TODO
        $this->customer = true;
    }
}
