<?php
    class HarvestDetail
    {
        private $id;
        private $eventid;
        private $db;

        public function __construct($id, $eventid)
        {
            $this->id = $id;
            $this->eventid = $eventid;
            $this->db = new AccountService();
        }

        public function getName()
        {
            $getname = $this->db->get("SPECIFIC_CROP", "CROP_NAME", "CROPID=" . $this->id);
            $name = $getname->fetch();
            echo "<h2>" . $name[0] . "</h2>";
        }

        public function getDate()
        {
            $getdate1 = $this->db->get("HARVEST_EVENT", "DATE_FROM", "EVENTID=" . $this->eventid);
            $date1 = $getdate1->fetch();

            echo "<p>" . "od " . $date1[0] . "</p>";

            $getdate2 = $this->db->get("HARVEST_EVENT", "DATE_TO", "EVENTID=" . $this->eventid);
            $date2 = $getdate2->fetch();

            echo "<p>" . "do " . $date2[0] . "</p>";
        }

        public function getPlace()
        {
            $getplace = $this->db->get("HARVEST_EVENT", "PLACE", "EVENTID=" . $this->eventid);
            $place = $getplace->fetch();
            echo "<p>" . $place[0] . "</p>";
        }

        public function getDescript()
        {
            $gettext = $this->db->get("HARVEST_EVENT", "DESCRIPTION", "EVENTID=" . $this->eventid);
            $text = $gettext->fetch();
            echo "<p>" . "Popis: " . $text[0] . "</p>";
        }

    }
?>