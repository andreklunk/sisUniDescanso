<?php

    $act            = isset($_REQUEST['act']) ? strip_tags($_REQUEST['act']) : "";
    $id      = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : "";
    $regn_p         = isset($_REQUEST['regn_p']) ? (int)$_REQUEST['regn_p'] : "";
    $regn_page_size = isset($_REQUEST['regn_page_size']) ? (int)$_REQUEST['regn_page_size'] : "";

    ################################################################################
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** define a relative (virtual) path to datagrid.class.php file (relatively to the current file)
    ##  *** RELATIVE PATH ONLY ***
    ##  Ex.: "datagrid/datagrid.class.php" or "datagrid.class.php" etc.
      define("DATAGRID_DIR", "datagrid/");                     
    require_once(DATAGRID_DIR.'datagrid.class.php');

      // includes database connection parameters
	  include_once('conexao.php');
           
    ##  *** set needed options and create a new class instance 
      $debug_mode = false;        /* display SQL statements while processing */    
      $messaging = true;          /* display system messages on a screen */ 
      $unique_prefix = "regn_";    /* prevent overlays - must be started with a letter */
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
      
    ##  *** set data source with needed options
    ##  *** put a primary key on the first place 
        $sql = "SELECT
              id_inf,
              IF(id_inf = ".(int)$id.", CONCAT('<span style=\"color:#ff0000\"><b>',titulo,'</b></span>'), titulo) as titulo, 'Ver Arquivos' as link_arquivos,
			  texto_centro, texto_rodape, ativo
            FROM informacoes";
      $default_order = array("id_inf"=>"DESC");
      $dgrid->DataSource("PDO", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);             
   
    ## +---------------------------------------------------------------------------+
    ## | 2. General Settings:                                                      | 
    ## +---------------------------------------------------------------------------+
    ## +-- PostBack Submission Method ---------------------------------------------+
    ##  *** defines postback submission method for DataGrid: AJAX, POST(default) or GET
    /// $postback_method = "post";
    /// $dgrid->SetPostBackMethod($postback_method);

     $dg_language = "pb";  
     $dgrid->SetInterfaceLang($dg_language);

    ##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
     $layouts = array("view"=>"0", "edit"=>"0", "details"=>"1", "filter"=>"2"); 
     $dgrid->setLayouts($layouts);

    ##  *** set modes for operations ("type" => "link|button|image") 
    ##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
     $modes = array(
         "add"	  =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "edit"	  =>array("view"=>false, "edit"=>false,  "type"=>"link", "byFieldValue"=>""),
         "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "delete"  =>array("view"=>false, "edit"=>false,  "type"=>"image")
     );
     $dgrid->setModes($modes);
    ##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
    ##  *** format (in which mode to allow processing of another datagrids)
    ##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
    // $anotherDatagrids = array("armo_"=>array("view"=>false, "edit"=>false, "details"=>false));
    // $dgrid->setAnotherDatagrids($anotherDatagrids);  
     $css_class = "x-blue";
     $dgrid->SetCssClass($css_class);
    ##  *** set DataGrid caption
     $dg_caption = "Informações - Tela Inicial";
     $dgrid->SetCaption($dg_caption);
    
    ## +---------------------------------------------------------------------------+
    ## | 3. Printing & Exporting Settings:                                         | 
    ## +---------------------------------------------------------------------------+
    ##  *** set printing option: true(default) or false 
     $printing_option = false;
     $dgrid->AllowPrinting($printing_option);

    ## +---------------------------------------------------------------------------+
    ## | 4. Sorting & Paging Settings:                                             | 
    ## +---------------------------------------------------------------------------+
    ##  *** set sorting option: true(default) or false 
     $sorting_option = true;
     $dgrid->AllowSorting($sorting_option);               
    ##  *** set paging option: true(default) or false 
     $paging_option = true;
     $rows_numeration = false;
     $numeration_sign = "N #";
     $dropdown_paging = true;
     $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
    ##  *** set paging settings
     $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
     $top_paging = array();
     $pages_array = array("2"=>"2", "5"=>"5", "10"=>"10", "15"=>"15", "25"=>"25", "50"=>"50", "100"=>"100");
     $default_page_size = 5;
     $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
     $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);

    ## +---------------------------------------------------------------------------+
    ## | 5. Filter Settings:                                                       | 
    ## +---------------------------------------------------------------------------+
    ##  *** set filtering option: true or false(default)
     $filtering_option = true;
     $show_search_type = true;
     $dgrid->AllowFiltering($filtering_option, $show_search_type);
    ##  *** set additional filtering settings
    /// $fill_from_array = array("0"=>"No", "1"=>"Yes");  /* as "value"=>"option" */
     $filtering_fields = array(
        "titulo"=>array("type"=>"textbox", "table"=>"Título", "field"=>"titulo", "filter_condition"=>"", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"", "on_js_event"=>""),
     );
     $dgrid->SetFieldsFiltering($filtering_fields);
    ##  *** set default filtering settings
    /// $dgrid->SetDefaultFiltering(array("table"=>"", "field_name"=>"", "field_value"=>""));

    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set view mode table properties
     $vm_table_properties = array("width"=>"60%");
     $dgrid->setViewModeTableProperties($vm_table_properties);  
    ##  *** set columns in view mode
    ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
     $vm_columns = array(  
        "id_inf"                =>array("header"=>"ID",     "type"=>"label",   "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "titulo"              =>array("header"=>"Título",   "type"=>"label", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "link_arquivos" =>array("header"=>"Action", "type"=>"link", "align"=>"center", "width"=>"150px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id_inf", "field_data"=>"link_arquivos", "rel"=>"", "title"=>"", "target"=>"_self",
                                    "href"=>"javascript:".$unique_prefix."_doPostBack('paging','','&regn_sort_field=id_inf&regn_sort_field_by=&regn_sort_field_type=&regn_sort_type=ASC&regn_page_size=1&regn_p=".$regn_p."&act=details&id={0}&regn_p=".$regn_p."&regn_page_size=".$regn_page_size."')")       
     );
     $dgrid->SetColumnsInViewMode($vm_columns);

    if($act == "details"){        
        ##  *** set needed options and create a new class instance 
         $debug_mode = false;        /* display SQL statements while processing */    
         $messaging = true;          /* display system messages on a screen */ 
         $unique_prefix = "cnt_";    /* prevent overlays - must be started with a letter */
         $dgrid1 = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
        
        ##  *** set data source with needed options
        ##  *** put a primary key on the first place 
          $sql=" SELECT   
              id_arquivo,
			  id_inf, 
              descricao              
          FROM arquivos 
          WHERE id_inf = ".(int)$id;                       
         $default_order = array("id_arquivo"=>"DESC");
         $dgrid1->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);             
         
         $css_class = "x-blue";
         $dgrid1->SetCssClass($css_class);
         
        ##  *** set DataGrid caption
         $dg_caption = "Arquivos para Download";
         $dgrid1->SetCaption($dg_caption);
        
        ##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
         $http_get_vars = array("act", "id");
         $dgrid1->SetHttpGetVars($http_get_vars);

         $anotherDatagrids = array("regn_"=>array("view"=>true, "edit"=>true, "details"=>true));
         $dgrid1->setAnotherDatagrids($anotherDatagrids);

        ## +---------------------------------------------------------------------------+
        ## | 3. Printing & Exporting Settings:                                         | 
        ## +---------------------------------------------------------------------------+
        ##  *** set printing option: true(default) or false 
         $printing_option = false;
         $dgrid1->AllowPrinting($printing_option);
        
        ## +---------------------------------------------------------------------------+
        ## | 6. View Mode Settings:                                                    | 
        ## +---------------------------------------------------------------------------+
        ##  *** set view mode table properties
         $vm_table_properties = array("width"=>"60%");
         $dgrid1->setViewModeTableProperties($vm_table_properties);  
        ##  *** set columns in view mode
        ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
        ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
         $vm_columns = array(  
            "descricao"       =>array("header"=>"Descrição",   "type"=>"label", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
         );
         $dgrid1->SetColumnsInViewMode($vm_columns);
        
        ## +---------------------------------------------------------------------------+
        ## | 7. Add/Edit/Details Mode settings:                                        | 
        ## +---------------------------------------------------------------------------+
        ##  ***  set settings for edit/details mode
         $em_table_properties = array("width"=>"60%");
         $dgrid1->SetEditModeTableProperties($em_table_properties);
         $dm_table_properties = array("width"=>"60%");
         $dgrid1->SetDetailsModeTableProperties($dm_table_properties);
        ##  ***  set settings for edit/details mode
         $table_name = "arquivos";
         $primary_key = "id_arquivo";
         $condition = "";
         $dgrid1->setTableEdit($table_name, $primary_key, $condition);

         $em_columns = array(
           "id_inf"        =>array("header"=>"Título", "type"=>"textbox",  "width"=>"210px", "req_type"=>"rt", "title"=>"Informação", "default"=>$id),
           "descricao"      =>array("header"=>"Descrição",     "type"=>"textarea", "width"=>"210px", "req_type"=>"rt", "title"=>"Descrição do Link", "edit_type"=>"simple", "rows"=>"3", "cols"=>"50"),
           "link"      =>array("header"=>"Link",     "type"=>"textarea", "width"=>"210px", "req_type"=>"rt", "title"=>"Link", "edit_type"=>"simple", "rows"=>"3", "cols"=>"50")
         );
         $dgrid1->SetColumnsInEditMode($em_columns);
        ##  *** set foreign keys for add/edit/details modes (if there are linked tables)
        ##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
        ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
         $foreign_keys = array(
        "id"=>array("table"=>"informacoes", "field_key"=>"id_inf", "field_name"=>"titulo", "view_type"=>"dropdownlist", "order_by_field"=>"titulo", "order_type"=>"ASC"),
         ); 
         $dgrid1->SetForeignKeysEdit($foreign_keys);        
    }

    ################################################################################   
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
    
    ob_start();    
      $dgrid->Bind();            
        
      if($act == "details"){
          echo "<br>";
          $dgrid1->Bind();                
      }
    ob_end_flush();    
    
?>