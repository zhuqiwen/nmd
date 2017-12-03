<h2>Guide</h2>
<h3>Usage</h3>
<ul>
	<li><h4>Search bar</h4></li>
	<p>Use search bar for all-text search. It will look into any text field of the database.</p>

	<li><h4>Filter</h4></li>
	<p>You can further filter the results returned by Search Bar. The reset buttom will reload the whole page.</p>

	<li><h4>Tab: records</h4></li>
	<p>This is where you investigate data details. Specifically, <b>doulbe click</b> any table row gives you a pop-up modal to view and edit details; you can also update the record from here. <b>Delete button</b> for each row pops up the deletion confirmation modal.</p>

	<li><h4>Tab: import from XML</h4></li>
	<p>Import data or wipe the database from here. The only accepted data file is <a href="http://www.iu.edu/~iubweb/academic/majors/xml/degree-list.xml">this degree records</a> in <b>the format of XML</b>. Before loaded into the database, the data <b>can be previewed</b>.</p>

</ul>
<h3>Development</h3>
<ul>
	<li><h4>Application Architecture</h4></li>
	<p>PHP scripts as the backend handle all the CRUD operations. The PHP scripts only presents a <b>single view</b> during the whole lifecycle of the application.</p>
	<p>Frontend rendering is handled by <b>JQuery and AJAX calls</b>. However, any changes that affect the state of data and database will trigger a whole-page reloading, to make sure the data displayed is up to date.</p>
	<p>Though the <b>search bar</b> retrieves data from <b>backend operations</b>, any <b>further filtering</b> (by the name of school and academic level) relies on <b>client side calculations</b> performed by browsers.</p>

	<li><h4>Infrastructure</h4></li>
	<p>Having been developing using MVC for years, I'm not very comfortable with a single .php file application. Instead, <b>I brewed a hand-made, micro MVC frame work</b> for this project, to ease the difficulties of development.</p>

	<li><h4>Database</h4></li>
	<p>You will need manually, as the root user, execute the <b>2 .sql files</b> to setup the schema. The schema is <b>not strict 3NF</b> because of the tight schedule of final weeks and the hardness of my boy's fever over the weekend.</p>
	<p>There are 2 tables, <i>degrees</i> and <i>schools</i>. Some constraints are employed to guarantee the data consistency. For example, the <i>degrees.school_id</i> is a FK of CASCADE DELETION, referring to <i>schools.id</i>. Some UNIQUE constraints on composite keys are also used to prevent data repetition that may be caused by <b>importing the same data file multiple times</b>.</p>

	<li><h4>Security</h4></li>
	<p>Again, due to tight schedule, I didn't implement any ACL or security module. However, it should not be hard to design and implement a middleware to guard the application.</p>

	<li><h4>Routing</h4></li>
	<p>The home-made MVC uses a simple way to <b>map url to array of controller, action and other parameters</b>. Currently, it doesn't support beautify url nor standard RESTFul API path.</p>

	<li><h4>Data Access Layer</h4></li>
	<p>The data access layer of this MVC framework consists of a model class and a self-made MySQL lib. The MySQL lib will be automatically loaded during the initialization of the Application class. It manages the connections using <a href="http://php.net/manual/en/book.mysqli.php"><b>mysqli library</b></a>.And due to tight schedule, pagination module was not implemented.</p>

	<li><h4>Controller</h4></li>
	<p>Since there no dedicated Routing module and Request class, I access the php super global variables directly, which I understand is not good practice, though it fastens the development. </p>

	<li><h4>The V Part</h4></li>
	<p>By not using any template languages, the processing speed and the implementation of this home-made MVC are facilitated. <i><b>require()</b></i> statement is employed to ease debugging, though in production, <i><b>include()</b></i> should be employed more often.</p>
	<p>The single application page is divided into <b>12 .php files</b>, according to their functionality and page layout. The main page is test.php, which I know may not be a good name.</p>

	<li><h4>JavaScirpt & CSS</h4></li>
	<p>JQuery is the major weapon for the front-end development of this project. <b>Pure JQuery</b> is employed, without any plugins, in order to <b>make it easier to read the script</b>.</p>
	<p>Bootstrap3 is employed to render the style of ths application. Only <b>1 ad-hoc</b> style sheet is placed in the head of the document to make the file uploader vertically centered. <b>No inline style</b> is used for the sake of layout consistency.</p>

</ul>
<h3>Thanks</h3>
<p>Hi, Greg and Jay</p>
<p>Thank you again for the interview. And thank you for reviewing my code for this project.</p>
<p>I know there are some bugs and weaknesses, and ugly codes in this submission. I am sorry if any of these causes difficulties while you are reading it.</p>
<p>I could have make the framework more standard if I'm not having such a tight schedule when it is final weeks and my 2-year is having a fever.</p>
<p>Anyway, thank you again for this opportunity.</p>
<p>Our best,</p>
<p>Sincerely</p>
<p>Qiwen Zhu</p>