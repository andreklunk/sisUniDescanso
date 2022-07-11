    <?php
     
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    |
    ## +---------------------------------------------------------------------------+
    ##  *** define a relative (virtual) path to datagrid.class.php file
    ##  *** directory (relatively to the current file)
    ##  *** RELATIVE PATH ONLY ***
    define ("DATAGRID_DIR", "datagrid/");                    
    require_once(DATAGRID_DIR."datagrid.class.php");
     
    ##  *** creating variables that we need for database connection    
   include_once('conexao.php');    
     
    ##  *** put a primary key on the first place
    $sql = "SELECT
       documento.id_documento,
       concat(pessoa.nome,' ',pessoa.sobrenome)as nome,
       documento.id_pessoa,
       documento.id_tipo,
       documento.doc_texto,
       documento.doc_tipo,
       documento.doc_conteudo,
	   documento.doc_tamanho,
	   documento.doc_arq,
	   tipo_doc.tipo_descricao
    FROM documento
       LEFT OUTER JOIN pessoa ON documento.id_pessoa = pessoa.id_pessoa 
       LEFT OUTER JOIN tipo_doc ON documento.id_tipo = tipo_doc.id_tipo";
     
    ##  *** set needed options and create a new class instance
    $debug_mode = false;        /* display SQL statements while processing */    
    $messaging = true;          /* display system messages on a screen */
    $unique_prefix = "prd_";    /* prevent overlays - must be started with a letter */
    $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
     
    ##  *** set data source with needed options
    $default_order = array("pessoa.nome"=>"ASC");
    $dgrid->DataSource("PDO", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);            
     
    ## +---------------------------------------------------------------------------+
    ## | 2. General Settings:                                                      |
    ## +---------------------------------------------------------------------------+
    ##  *** set interface language (default - English)
    $dg_language = "pb";  
    $dgrid->SetInterfaceLang($dg_language);
    ##  *** set modes for operations ("type" => "link|button|image")
    $modes = array(
     "add"    =>array("view"=>true, "edit"=>false, "type"=>"link", "show_add_button"=>"outside"),
     "edit"   =>array("view"=>true, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
     "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
     "delete"  =>array("view"=>true, "edit"=>true,  "type"=>"image")
    );
    $dgrid->SetModes($modes);
    ##  *** allow multirow operations
    $multirow_option = true;
    $dgrid->AllowMultirowOperations($multirow_option);
    $multirow_operations = array("edit"  => array("view"=>false), "delete"  => array("view"=>true), "details" => array("view"=>true));
    $dgrid->SetMultirowOperations($multirow_operations);  
    ##  *** set CSS class for datagrid
    $css_class = "default";
    $dgrid->SetCssClass($css_class);
    ##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
    ##  *** set DataGrid caption
    $dg_caption = "Documentação";
    $dgrid->SetCaption($dg_caption);
     
    ## +---------------------------------------------------------------------------+
    ## | 4. Sorting & Paging Settings:                                             |
    ## +---------------------------------------------------------------------------+
    ##  *** set paging option: true(default) or false
    $paging_option = true;
    $rows_numeration = false;
    $numeration_sign = "N #";
    $dropdown_paging = true;
    $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
    ##  *** set paging settings
    $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
    $top_paging = array();
    $pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
    $default_page_size = 10;
    $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
    $dgrid->setPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
     
    ## +---------------------------------------------------------------------------+
    ## | 5. Filter Settings:                                                       |
    ## +---------------------------------------------------------------------------+
    ##  *** set filtering option: true or false(default)
    $filtering_option = true;
    $show_search_type = true;
    $dgrid->AllowFiltering($filtering_option, $show_search_type);
    ##  *** set additional filtering settings
    $filtering_fields = array(
     "Tipo Documento" => array("type"=>"enum", "view_type"=>"dropdownlist",  "order"=>"ASC", "table"=>"tipo_doc", "field"=>"tipo_descricao", "source"=>"self", "show"=>"", "condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"", "multiple"=>"false", "multiple_size"=>"4", "on_js_event"=>""),
     "Nome"       =>array("type"=>"textbox",  "table"=>"pessoa", "field"=>"nome", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"200px", "on_js_event"=>""),
    );
    $dgrid->SetFieldsFiltering($filtering_fields);
     
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    |
    ## +---------------------------------------------------------------------------+
    ##  *** set view mode table properties
    $vm_table_properties = array("width"=>"95%");
    $dgrid->SetViewModeTableProperties($vm_table_properties);  
    ##  *** set columns in view mode
    $vm_columns = array(
     "nome"              => array("header"=>"Nome", "header_tooltip"=>"Model and Model Type", "header_tooltip_type"=>"simple", "type"=>"linktoedit", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>"false", "case"=>"normal", "summarize"=>"false", "sort_type"=>"string", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
	 "tipo_descricao"       =>array("header"=>"Tipo Documento", "type"=>"label", "align"=>"left", "wrap"=>"wrap",   "text_length"=>"20", "case"=>"normal"),
     "doc_conteudo"       => array("header"=>"Imagem", "type"=>"image", "align"=>"center", "width"=>"58x", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>"false", "summarize"=>"false", "sort_type"=>"string", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"blob", "default"=>"default_image.ext", "image_width"=>"50px", "image_height"=>"30px", "magnify"=>"true", "magnify_type"=>"magnifier", "magnify_power"=>"3", 'save_as'=>'blob'),
    );
    $dgrid->SetColumnsInViewMode($vm_columns);
     
    ## +---------------------------------------------------------------------------+
    ## | 7. Add/Edit/Details Mode Settings:                                        |
    ## +---------------------------------------------------------------------------+
    ##  *** set add/edit mode table properties
    $em_table_properties = array("width"=>"70%");
    $dgrid->SetEditModeTableProperties($em_table_properties);
    ##  *** set details mode table properties
    $dm_table_properties = array("width"=>"70%");
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
    ##  ***  set settings for add/edit/details modes
    $table_name  = "documento";
    $primary_key = "id_documento";
    $condition   = "";
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
    ##  *** set columns in edit mode  
   // $fill_from_array_sales = array();
 //   for($i=1; $i<100; $i++){ $fill_from_array_sales[$i] = $i; }
 //   $fill_from_array_chargers = array("linear_regulator"=>"Linear Regulator", "switch_mode"=>"Switch Mode", "shunt_regulators"=>"Shunt Regulators", "pulsed_charging"=>"Pulsed Charging");
     $arquivo = 'arq_'.uniqid();
    $em_columns = array(
     "delimiter_0"   =>array("inner_html"=>"Textbox and dropdown list fields: They are basic fields for each DataGrid. Supplier is an example of Foreign Key with possibility to select value from dropdown list."),
     "id_tipo"   =>array("header"=>"Tipo Documento", "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	 "id_pessoa"   =>array("header"=>"Pessoa", "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	// "doc_conteudo"     =>array("header"=>"Imagem", "type"=>"image", "req_type"=>"st", "save_as"=>"blob", "blob_filetype"=>"doc_tipo", "blob_filename"=>"doc_arq", "blob_filesize"=>"doc_tamanho", "target_path"=>"uploads/", "width"=>"220px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "max_file_size"=>"900K", "image_width"=>"240px", "image_height"=>"180px", "magnify"=>"true", "magnify_type"=>"lightbox"),
	// "doc_conteudo"     =>array("header"=>"Imagem", "type"=>"image", "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"900K", "image_width"=>"240px", "image_height"=>"180px", "magnify"=>"true", "magnify_type"=>"lightbox", "file_name"=>"$arquivo", "host"=>"local", "save_as"=>"blob", "blob_filetype"=>"blob_type", "blob_filename"=>"blob_name", "blob_filesize"=>"blob_size"),
	 'doc_conteudo'=>array('header'=>'Arquivo','visible'=>'true','type'=>'image','req_type'=>'st','readonly'=>'false',"save_as"=>"blob", "blob_filetype"=>"doc_tipo", "blob_filename"=>"doc_arq", "blob_filesize"=>"doc_tamanho",'allow_downloading'=>'true'),
    );
    $dgrid->SetColumnsInEditMode($em_columns);
    ##  *** set foreign keys for add/edit/details modes (if there are linked tables)
    $foreign_keys = array(
     "id_tipo"=>array("table"=>"tipo_doc", "field_key"=>"id_tipo", "field_name"=>"tipo_descricao", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"tipo_descricao", "order_type"=>"ASC", "on_js_event"=>""),
	 "id_pessoa"=>array("table"=>"pessoa", "field_key"=>"id_pessoa", "field_name"=>"nome", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"nome", "order_type"=>"ASC", "on_js_event"=>""),
    );
    $dgrid->SetForeignKeysEdit($foreign_keys);
     
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     |
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
    $dgrid->Bind();        
     
    ?>
