##The way to set this up on a department machine is a little weird so I'll do my best to cover it well:

- First, you need to be in the root directory of the department machine ie. for me it's sammckay (Then all of my other folders and stuff within this directory)

- After that, you need to clone the repo to this directory using git clone https://github.com/Retrope13/CS312-Project.git but you should copy the URL yourself just in case it's different

- Then you will use chmod -R 755 CS312-Project which gives it the proper permissions

- Finally, you will have to make an m1 in the local_html folder that contains a copy of the contents of cs312/fuelviews. In the m1/fuelviews/index.php where it says define('APPPATH', realpath(DIR.'/../../../fuel/app/').DIRECTORY_SEPARATOR); you need to change this to define('APPPATH', realpath(DIR.'/../../../CS312-Project/fuel/app/').DIRECTORY_SEPARATOR);

^^ This above modification needs to also be done for COREPATH and PKGPATH

When all of this is done you should be able to reach the website at the URL https://cs.colostate.edu:4444/~[EID]/m1/fuelviews/index.php/colorpicker/index
