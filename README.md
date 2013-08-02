Flexi Layout Library
=============
--------------------------

The Codeigniter Flexi Layout Library makes it easy to create more usable and manageable layouts.  This library allows you manage multiple themes, multiple page templates (page layouts), partial view files and partial view data along with the setting and loading of your JavaScript, CSS and page meta data.  The library allows you to manage your view files using a DRY (don't repeat yourself) principle.

Documentation
=============
----------

Check out the full documentation [http://creativeinflux.co.uk/lab/codeigniter_flexi_layout_library](http://creativeinflux.co.uk/lab/codeigniter_flexi_layout_library)


Quick Start Guide
=================
--------------

Download the library and add the files to your application folder, the quick start guide assumes you have all the files in place and correct folder structure.  Check out [folder structure](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/folder_stucture.php) for more info on file and folder locations.

Load the library from within your controller using the CodeIgniter load method:

`$this->load->library('Flexi');`

You can also load the library from within your autoload file, the autoload file can be found within the application config folder.

Create your theme folder within your flexi folder (The download comes with an example theme) and add a template file to the new theme folder (the example also contains an example template file).  Template files are the different page designs/layouts so for a page template make a page.php file or for a homepage make a homepage.php file.

Inside your template file you should place at least the getContent() method which will get and output the requested page content:

`<?= $this->Flexi->getContent() ?>`

You can also add partial views in your template files.  For more info on [partials](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/partials.php) and loading [CSS and JavaScript files](http://www.creativeinflux.co.uk//lab/codeigntier_flexi_layout_library/template_methods.php) check out their respective pages.

The theme and template properties must be set for the library to be able to select the correct files.  You can set the theme name and template name from within your [config file](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/config.php) or from inside controller.  Set the properties in your controller like so:

`$this->Flexi->theme('example');`


`$this->Flexi->template('template_page_example');`

All of the prerequisites should now be set so we can load the actual content, content files are stored in the view folder outside of the theme folder.  Load the view as below, you can also pass variables into the second parameter just like loading a normal view:

`
$data = array(
	'variable' => 'some variables'
);`

`$this->Flexi->make('home', $data);`


Your variable can be accessed by calling the variable inside your content view file:

`<?= $variable ?>`

Thats the basics to the Flexi layout library but we have only just scratched the surface, checkout the rest of the guide for more on [partials](http://www.creativeinflux.co.uk/lab/codeignter_flexi_layout_library/partials.php), setting [config items](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/config.php) and [template methods](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/template_methods.php) or visit the [API](http://www.creativeinflux.co.uk/lab/codeigniter_flexi_layout_library/api.php) for a list of all the available methods.


Acknowledgments
===============
--------------------------------

If you need support or want to show some love tweet me [@creativeinflux](https://twitter.com/creativeinflux)

* My website ([creativeinflux.co.uk](http://www.creativeinflux.co.uk))
* Github ([@creativeinflux](https://github.com/creativeinflux))
* Twitter ([@creativeinflux](https://twitter.com/creativeinflux))