<table>

    <?php
    require "services.php";
    class HarvestDetail
    {
        private $id;
        private $db;

        public function __construct($id) {
            $this->id = $id;
            $this->db = new AccountService();
        }

        public function getName(){
            $getname = $this->db->get("SPECIFIC_CROP","CROP_NAME","CROPID=" . $this->id);
            $name = $getname->fetch();
            echo $name[0] . "<br>";
        }

        public function getDate(){
            $getdate1 = $this->db->get("HARVEST_EVENT E, HARVEST_CROP C","E.DATE_FROM","E.EVENTID = C.EVENTID AND C.CROPID=" . $this->id);
            $date1 = $getdate1->fetch();

            echo "od " . $date1[0] . "<br>";

            $getdate2 = $this->db->get("HARVEST_EVENT E, HARVEST_CROP C","E.DATE_TO","E.EVENTID = C.EVENTID AND C.CROPID=" . $this->id);
            $date2 = $getdate2->fetch();

            echo "do " . $date2[0] . "<br>";
        }

        public function getPlace(){
            $getplace = $this->db->get("HARVEST_EVENT E, HARVEST_CROP C","E.PLACE","E.EVENTID = C.EVENTID AND C.CROPID=" . $this->id);
            $place = $getplace->fetch();
            echo $place[0] . "<br>";
        }

        public function getDescript(){
            $gettext = $this->db->get("HARVEST_EVENT E, HARVEST_CROP C","E.DESCRIPTION","E.EVENTID = C.EVENTID AND C.CROPID=" . $this->id);
            $text = $gettext->fetch();
            echo "Popis: " . $text[0] . "<br>";
        }

        public function submit(){
            if(array_key_exists('login', $_POST)) {
                echo "Jsi přihlášen na samosběr";
            }
        }


    }
    $harvest = new HarvestDetail(1); // zde budeme volat příslušné ID produktu
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