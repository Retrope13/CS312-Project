<?php

class Controller_ColorPicker extends Controller_Template {

    public $title = "";

    public function action_index() {

        $data = array();
        $this->template->title= "Color Picker Home";
        $this->template->css = "picker.css";
        $this->template->content = View::forge('colorpicker/index', $data);

    }

    public function action_about() {
        $data = array();
        $this->template->title = "About Page";
        $this->template->css = "picker.css";
        $this->template->content = View::forge('colorpicker/about.php', $data);

    }


}