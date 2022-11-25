<table>

    <?php
    require "services.php";
    class HarvestDetail
    {
        private $id;
        private $eventid;
        private $db;

        public function __construct($id, $eventid) {
            $this->id = $id;
            $this->eventid = $eventid;
            $this->db = new AccountService();
        }

        public function getName(){
            $getname = $this->db->get("SPECIFIC_CROP","CROP_NAME","CROPID=" . $this->id);
            $name = $getname->fetch();
            echo $name[0] . "<br>";
        }

        public function getDate(){
            $getdate1 = $this->db->get("HARVEST_EVENT","DATE_FROM","EVENTID=" . $this->eventid);
            $date1 = $getdate1->fetch();

            echo "od " . $date1[0] . "<br>";

            $getdate2 = $this->db->get("HARVEST_EVENT","DATE_TO","EVENTID=" . $this->eventid);
            $date2 = $getdate2->fetch();

            echo "do " . $date2[0] . "<br>";
        }

        public function getPlace(){
            $getplace = $this->db->get("HARVEST_EVENT","PLACE","EVENTID=" . $this->eventid);
            $place = $getplace->fetch();
            echo $place[0] . "<br>";
        }

        public function getDescript(){
            $gettext = $this->db->get("HARVEST_EVENT","DESCRIPTION","EVENTID=" . $this->eventid);
            $text = $gettext->fetch();
            echo "Popis: " . $text[0] . "<br>";
        }

        public function submit(){
            if(array_key_exists('login', $_POST)) {
                $this->db->add("HARVEST_EVENT_ATTENDANTS", "(" . $this->eventid . "login" . ")");
                echo "Jsi přihlášen na samosběr";
            }
        }


    }
    $harvest = new HarvestDetail(1,3); // zde budeme volat příslušné ID (produktu) a eventu
    $harvest->getName();
    $harvest->getDate();
    $harvest->getPlace();
    $harvest->getDescript();
    $harvest->submit();

    ?>

    <form method="post">
        <input type="submit" name="login"
                class="button" value="Přihlásit se" />
    </form>
    
</table>