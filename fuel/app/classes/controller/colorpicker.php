<?php
use Fuel\Core\Form;

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
        $this->template->title = "test";
        $this->template->css = "table.css";
        $this->template->content = View::forge('colorpicker/colorTable', $data);
            // If the page is being loaded without GET parameters, show the form
    if (empty($_GET)) {
        // Show the form for entering the number of rows/columns and colors
        // This would typically involve loading a view file that contains the HTML for the form
        // You may want to use Fuel's Form class to create the form elements
        
      } else {
        // If the page is being loaded with GET parameters, validate them and generate the color coordinate sheet
        
        // Validate the user input
        $rows = (int)$_GET['rows'];
        $colors = (int)$_GET['colors'];
        
        // Check if the input is valid
        if ($rows < 1 || $rows > 26 || $colors < 1 || $colors > 10) {
          // If the input is invalid, show the form again with an error message
          // You may want to use Fuel's Session class to store the error message and display it on the form
        } else {
          // If the input is valid, generate the color coordinate sheet
          
          // Create an array of color options for the drop-downs
          $color_options = array('red', 'orange', 'yellow', 'green', 'blue', 'purple', 'grey', 'brown', 'black', 'teal');
          
          // Generate the upper table with the drop-downs
          $upper_table = '<table>';
          for ($i = 0; $i < $colors; $i++) {
            // Add a row with a label and a drop-down
            $upper_table .= '<tr><td>Color ' . ($i + 1) . ':</td><td><select name="color' . $i . '">';
            // Add the color options to the drop-down
            foreach ($color_options as $color) {
              $selected = '';
              // If this color was already selected in another drop-down, mark it as disabled
              if (in_array($color, array_slice($_GET, 3))) {
                $selected = 'disabled';
              }
              // Add the option to the drop-down
              $upper_table .= '<option value="' . $color . '" ' . $selected . '>' . ucfirst($color) . '</option>';
            }
            $upper_table .= '</select></td></tr>';
          }
          $upper_table .= '</table>';
          
          // Generate the lower table with the coordinates
          if ($rows >= 1) {
            $lower_table = '<table>';
          // Add the header row with the letters
            $lower_table .= '<tr><td></td>';
            $lower_table .= '</tr>';
          // Add the rows with the numbers and cells
            for ($i = 1; $i <= $rows; $i++) {
              $lower_table .= '<tr><td>' . $i . '</td>';

            }
              $lower_table .= '</tr>';  
            }
            $lower_table .= '</table>';
          }
        }
      }
  }