<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Active template
|--------------------------------------------------------------------------
|
| The $template['active_template'] setting lets you choose which template 
| group to make active.  By default there is only one group (the 
| "default" group).
|
*/
$template['active_template'] = 'default';


/*
|--------------------------------------------------------------------------
| Explaination of template group variables
|--------------------------------------------------------------------------
|
| ['template'] The filename of your master template file in the Views folder.
|   Typically this file will contain a full XHTML skeleton that outputs your
|   full template or region per region. Include the file extension if other
|   than ".php"
| ['regions'] Places within the template where your content may land. 
|   You may also include default markup, wrappers and attributes here 
|   (though not recommended). Region keys must be translatable into variables 
|   (no spaces or dashes, etc)
| ['parser'] The parser class/library to use for the parse_view() method
|   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
|   Smarty Parser that works perfectly with Template
| ['parse_template'] FALSE (default) to treat master template as a View. TRUE
|   to user parser (see above) on the master template
|
| Region information can be extended by setting the following variables:
| ['content'] Must be an array! Use to set default region content
| ['name'] A string to identify the region beyond what it is defined by its key.
| ['wrapper'] An HTML element to wrap the region contents in. (We 
|   recommend doing this in your template file.)
| ['attributes'] Multidimensional array defining HTML attributes of the 
|   wrapper. (We recommend doing this in your template file.)
|
| Example:
| $template['default']['regions'] = array(
|    'header' => array(
|       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
|       'name' => 'Page Header',
|       'wrapper' => '<div>',
|       'attributes' => array('id' => 'header', 'class' => 'clearfix')
|    )
| );
|
*/

/*
|--------------------------------------------------------------------------
| Default Template Configuration (adjust this or create your own)
|--------------------------------------------------------------------------
*/


### Template for the User pages starts ###
$template['default']['template'] = 'Template/template';


$template['default']['regions']['metatags'] = array(
		  'content' => array('<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="description" content="" />
<meta name="Author" content="" />
<meta name="keyphrase" content="" />
<meta name="Title" content="" />
<meta name="classification" content="" />
<meta name="distribution" content="global" />
<meta name="rating" content="General" />
<meta name="subject" content="" />
<meta name="page-type" content="" />
<meta name="audience" content="all" />
<meta name="revisit-after" content="7 days" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />'),
    	  'name' => 'Metatags'
);

$template['default']['regions']['headerpane'] =  array(
  		  'content' => array('<a href="'.base_url().'home" title="" class="cam-logo"><!--rskEmptyTag-->&nbsp;</a>'),
    	  'name' => 'PageHeader',
    	  'wrapper' => '<div>',
    	  'attributes' => array('class' => 'headerpane-logo')
);

		  



$template['default']['regions']['contentpane']= array(
    	  'name' => 'contentpane',
);

$template['default']['regions']['footerpane'] =  array(

'content' => array('<div id="footer-wrapper">
                 <p>&copy; Hot Torque PTY. LTD </p>
                 <ul id="navigation-3">
                    <li><a href="'.base_url().'home/about">About</a></li>
                    <!--li><a href="'.base_url().'home/help">Help</a></li-->
                    <li><a href="'.base_url().'home/terms">Terms</a></li>
                    <li><a href="'.base_url().'home/privacy">Privacy</a></li>
                    <li><a href="'.base_url().'article/techarticle">Technical Articles</a></li>
					<li><a href="'.base_url().'home/contact">Contact</a></li>
                    <!--li><a href="#">Blog</a></li-->
                </ul>
               
                </div>
            </div>
        </div>
    </div>
</div>'),
    	  'name' => 'footerpane'
    	
);


### Template for the User pages ends ###


### Template for the Admin Inner pages starts ###
$template['admin']['template'] = 'Template/templateAdmin';

$template['admin']['regions']['metatags'] = array(
		  'content' => array('<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="description" content="Looking for uniforms online? Find quality uniforms for your business.Cambridge Company          is one of the leading 
canadian company providing fine garments to schools and organizations. We specailize in designing custom school uniforms. 		  We designjust what you want with superior quality, great prices, 
and the kind of service that\'s hard to find." />
<meta name="keywords" content="custom uniforms, apparel, ready to wear garments, customize a uniform, embroidered uniforms, school uniforms
personalized, customized, custom corporate apparel, uniform company,uniforms, work uniforms, nursing uniforms, quality uniforms, uniform shirts, 
uniform rentals, uniform services, work apparel, uniform purchase, workwear, work clothing, corporate apparel, aramark, aramark-uniform, 
shop aramark, wearguard" />
<meta name="Author" content="" />
<meta name="keyphrase" content="" />
<meta name="Title" content="" />
<meta name="classification" content="" />
<meta name="distribution" content="global" />
<meta name="rating" content="General" />
<meta name="subject" content="" />
<meta name="page-type" content="" />
<meta name="audience" content="all" />
<meta name="revisit-after" content="7 days" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />'),
    	  'name' => 'Metatags'
);

$template['admin']['regions']['contentpane']= array(
    	  'name' => 'contentpane',
);


$template['admin']['regions']['footerpane'] =  array(

'content' => array('<span style="color:#961962;">Copyright 2011 Complete Internet Services Pty Ltd. All Rights Reserved.</span>'),
    	  'name' => 'footerpane'
    	
);


# END OF TEMPLATE FOR ADMIN SECTION



$template['default']['parser'] = 'parser';
$template['default']['parser_method'] = 'parse';
$template['default']['parse_template'] = TRUE;

/* End of file template.php */
/* Location: ./system/application/config/template.*/