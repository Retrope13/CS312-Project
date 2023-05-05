<?php
use Fuel\Core\Session;
use Fuel\Core\Response;

class Controller_ColorPicker extends Controller_Template {

    public $title = "";
    public $rows = 0;

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


    public function getRows() {
      if (empty($_GET)) {

      } else {
        $rows = (int)$_GET['rows'];
        return $rows;
      }
    }

    public function getColors() {
      if (empty($_GET)) {

      } else {
        $colors = (int)$_GET['colors'];
        return $colors;
      }
    }

    public function action_table() {

        $data = array();
        $this->template->title = "Color Picker";
        $this->template->css = "table.css";
        $this->template->content = View::forge('colorpicker/colorTable', $data);
    if (empty($_GET)) {
      } else {
        
        // Validate the user input
        $rows = (int)$_GET['rows'];
        $colors = (int)$_GET['colors'];
        
        // Check if the input is valid
        if (($rows < 1 || $rows > 26) && ($colors < 1 || $colors > 10)) {
          Session::set_flash('error', 'make sure that the number of rows is greater than 0 and less than 27. Colors must also be greater than 0 and less than 11');
        }
        elseif($rows < 1 || $rows > 26) {
          Session::set_flash('error', 'make sure that rows is greater 0 and less than 27');
        }elseif($colors < 1 || $colors > 10) {
          Session::set_flash('error', 'make sure that colors is greater than 0 and less than 11');
        }
      }
    }

    public function action_print() {
      $data = array(
        'rows' => $this->getRows(),
        'colors' => $this->getColors()
      );

      $this->template->title = "Print View";
      $this->template->css = "print.css";
      return Response::forge(View::forge('colorpicker/print', $data));
  }
  
  }