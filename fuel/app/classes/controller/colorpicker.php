<?php

class Controller_ColorPicker extends Controller_Template {

    public $title = "";

    public function action_index() {

        $data = array();
        $this->template->title= "Color Picker Home";
        $this->template->css = "main.css";
        $this->template->content = View::forge('colorpicker/index', $data);

    }

    public function action_about() {
        $data = array();
        $this->template->title = "About Page";
        $this->template->css = "about.css";
        $this->template->content = View::forge('colorpicker/about.php', $data);

    }

    public function action_table() {
        $data = array();
        $this->template->title = "Table Page";
        $this->template->css = "table.css";
        $this->template->content = View::forge('colorpicker/colorTable.php', $data);
    }


}