<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Drag and Drop between 2 TreePanels</title>
<link rel="stylesheet" type="text/css" href="/sfExtjs2Plugin/extjs/resources/css/ext-all.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="/sfExtjs2Plugin/extjs/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="/sfExtjs2Plugin/extjs/ext-all.js"></script>
<script type="text/javascript" src="/sfExtjs2Plugin/extjs/examples/tree/two-trees.js"></script>

<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="/sfExtjs2Plugin/extjs/shared/examples.css" />
<style type="text/css">
    #tree, #tree2 {
    	float:left;
    	margin:20px;
    	border:1px solid #c3daf9;
    	width:250px;
    	height:300px;
    }
    .folder .x-tree-node-icon{
		background:transparent url(/sfExtjs2Plugin/extjs/resources/images/default/tree/folder.gif);
	}
	.x-tree-node-expanded .x-tree-node-icon{
		background:transparent url(/sfExtjs2Plugin/extjs/resources/images/default/tree/folder-open.gif);
	}
    </style>
</head>
<body>
<script type="text/javascript" src="/sfExtjs2Plugin/extjs/shared/examples.js"></script><!-- EXAMPLES -->
<h1>Drag and Drop betweens two TreePanels</h1>
<p>The TreePanels have a TreeSorter applied in "folderSort" mode.</p>
<p>Both TreePanels are in "appendOnly" drop mode since they are sorted.</p>
<p>Drag along the edge of the tree to trigger auto scrolling while performing a drag and drop.</p>
<p>The data for this tree is asynchronously loaded with a JSON TreeLoader.</p>
<p>The js is not minified so it is readable. See <a href="two-trees.js">two-trees.js</a>.</p>

<div id="tree"></div>
<div id="tree2"></div>

</body>
</html>
