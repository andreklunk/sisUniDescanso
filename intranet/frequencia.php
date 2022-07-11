<?php
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
if($_SESSION['us_sessao']!=session_id())
{
	header("Location: index.php?mensagem=erro_sessao");
}
$_SESSION['us_sessao'];
$_SESSION['us_id'];
$_SESSION['us_nome'];

 ################################################################################
 ## +---------------------------------------------------------------------------+
 ## | 1. Creating & Calling:                                                    | 
 ## +---------------------------------------------------------------------------+
 ##  *** define a relative (virtual) path to datagrid.class.php file
 ##  *** (relatively to the current file)
 ##  *** RELATIVE PATH ONLY ***

    $unique_prefix = "prs_";    /* prevent overlays - must be started with a letter */
    $postback   = (isset($_REQUEST['postback']) && $_REQUEST['postback'] != "") ? strip_tags($_REQUEST['postback']) : "ajax";
    $mode       = isset($_REQUEST[$unique_prefix.'mode']) ? $_REQUEST[$unique_prefix.'mode'] : "";    
    $region_id  = isset($_REQUEST["riyregion_id"]) ? $_REQUEST["riyregion_id"] : "";

    define("DATAGRID_DIR", "datagrid/");                     
    require_once(DATAGRID_DIR.'datagrid.class.php');

    // includes database connection parameters
  //  include_once('config.inc.php');
    include_once('conexao.php');
    ob_start();

 ##  *** set needed options and create a new class instance 
  $debug_mode = false;        /* display SQL statements while processing */    
  $messaging = true;          /* display system messages on a screen */ 
  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
 ##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
 /// $dg_encoding = "utf8";
 /// $dg_collation = "utf8_unicode_ci";
 /// $dgrid->SetEncoding($dg_encoding, $dg_collation);
 ##  *** set data source with needed options
 ##  *** put a primary key on the first place 
    $sql=" SELECT 
            id_frequencia, 
            data_cadastro,
			frequencia.id_pessoa, 
			concat(pessoa.nome,' ',pessoa.sobrenome)as nome,
            frequencia.id_curso, 
            frequencia.id_instituicao,
			frequencia.id_parcela,
			num_dias_trans,
			num_disciplinas,
			concat(parcela.descricao,' - ',parcela.semestre,'/',parcela.ano)as parcela,
			validacao,
			dt_alteracao
        FROM frequencia
		LEFT OUTER JOIN pessoa ON frequencia.id_pessoa=pessoa.id_pessoa
		LEFT OUTER JOIN curso ON frequencia.id_curso=curso.id_curso
		LEFT OUTER JOIN instituicao ON frequencia.id_instituicao=instituicao.id_instituicao
		LEFT OUTER JOIN parcela ON frequencia.id_parcela=parcela.id_parcela";
  $default_order = array("id_frequencia"=>"desc");
  $dgrid->DataSource("PDO", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);             

 ## +---------------------------------------------------------------------------+
 ## | 2. General Settings:                                                      | 
 ## +---------------------------------------------------------------------------+
 ## +-- PostBack Submission Method ---------------------------------------------+
 ##  *** defines postback submission method for DataGrid: AJAX, POST or GET(default)
  $postback_method = "post";
  $dgrid->SetPostBackMethod($postback_method);
 ##  *** set interface language (default - English)
 $dg_language = "pb";  
 $dgrid->SetInterfaceLang($dg_language);
 ##  *** set direction: "ltr" or "rtr" (default - "ltr")
 /// $direction = "ltr";
 /// $dgrid->SetDirection($direction);
 ##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
  $layouts = array("view"=>"0", "edit"=>"1", "details"=>"1", "filter"=>"2"); 
  $dgrid->SetLayouts($layouts);
 /// $details_template = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr>...</table>";
 /// $dgrid->SetTemplates("","",$details_template);
 ##  *** set modes for operations ("type" => "link|button|image")
 ##  *** "view" - view mode | "edit" - add/edit/details modes
 ##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
 /// $modes = array(
 ///     "add"	  =>array("view"=>true, "edit"=>false, "type"=>"link", "show_add_button"=>"inside|outside"),
 ///     "edit"	  =>array("view"=>true, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
 ///     "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
 ///     "delete"  =>array("view"=>true, "edit"=>true,  "type"=>"image")
 /// );
 /// $dgrid->SetModes($modes);
 ##  *** allow scrolling on datagrid
 /// $scrolling_option = false;
 /// $dgrid->AllowScrollingSettings($scrolling_option);  
 ##  *** set scrolling settings (optional)
 /// $scrolling_height = "200px";
 /// $dgrid->SetScrollingSettings($scrolling_height);
 ##  *** allow multirow operations
   $multirow_option = false;
   $dgrid->AllowMultirowOperations($multirow_option);
   $multirow_operations = array(
       "edit"  => array("view"=>true),
       "delete"  => array("view"=>true),
       "details" => array("view"=>true),
   );
   $dgrid->SetMultirowOperations($multirow_operations);  
 ##  *** set CSS class for datagrid
 ##  *** "default" or "blue" or "gray" or "green" or "pink" or your own css file 
   $css_class = "x-blue";
   $dgrid->SetCssClass($css_class);
 ##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
 // $http_get_vars = array("id");
 // $dgrid->SetHttpGetVars($http_get_vars);
 ##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
 ##  *** format (in which mode to allow processing of another datagrids)
 ##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
 /// $otherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
 /// $dgrid->SetOtherDatagrids($otherDatagrids);  
 ##  *** set DataGrid caption
  $dg_caption = "Frequências <br> Clique no Nº da Inscrição para impressão do Comprovante";
  $dgrid->SetCaption($dg_caption);

 ## +---------------------------------------------------------------------------+
 ## | 3. Printing & Exporting Settings:                                         | 
 ## +---------------------------------------------------------------------------+
 ##  *** set printing option: true(default) or false 
  $printing_option = false;
  $dgrid->AllowPrinting($printing_option);
 ## +-- Exporting --------------------------------------------------------------+
 ##  *** initialize the session with session_start();
 ##  *** default exporting directory: tmp/export/
 //$exporting_option = true;
//  $export_all = false;
 // $dgrid->AllowExporting($exporting_option, $export_all);
 // $exporting_types = array('csv'=>'true', 'xls'=>'true', 'pdf'=>'true', 'xml'=>'true');
 // $dgrid->AllowExportingTypes($exporting_types);

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
  $pages_array = array("5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
  $default_page_size = 50;
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
    "Ano"       =>array("type"=>"textbox",  "table"=>"parcela", "field"=>"ano", "show_operator"=>"false", "default_operator"=>"=%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"60px", "on_js_event"=>""),
    "Semestre"       =>array("type"=>"textbox",  "table"=>"parcela", "field"=>"semestre", "show_operator"=>"false", "default_operator"=>"=%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"30px", "on_js_event"=>""),
	"Parcela"       =>array("type"=>"textbox",  "table"=>"parcela", "field"=>"id_parcela", "show_operator"=>"false", "default_operator"=>"=%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"30px", "on_js_event"=>""),
	"Nome"       =>array("type"=>"textbox",  "table"=>"pessoa", "field"=>"nome", "show_operator"=>"false", "default_operator"=>"%like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"250px", "on_js_event"=>""),
	 "Validação"     =>array("type"=>"enum",     "table"=>"frequencia", "field"=>"validacao", "field_view"=>"", "filter_condition"=>"", "order"=>"ASC", "source"=>"self", "condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"", "multiple"=>"false", "multiple_size"=>"4", "on_js_event"=>"", "view_type"=>"radiobutton"),
	);
  $dgrid->SetFieldsFiltering($filtering_fields);

 ## +---------------------------------------------------------------------------+
 ## | 6. View Mode Settings:                                                    | 
 ## +---------------------------------------------------------------------------+

 ##  *** set view mode table properties
  $vm_table_properties = array("width"=>"75%");
  $dgrid->SetViewModeTableProperties($vm_table_properties);  
 ##  *** set columns in view mode
 ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
 ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
  /// $fill_from_array = array("0"=>"Banned", "1"=>"Active", "2"=>"Closed", "3"=>"Removed"); /* as "value"=>"option" */
  $vm_colimns = array(
 "id_frequencia"       => array ("header"=>"Nº Inscr.", "type"=>"link", "align"=>"center", "wrap"=>"wrap",   "text_length"=>"11", "case"=>"normal",  'field_key'=>'id_frequencia', 'field_data'=>'id_frequencia', 'rel'=>'', 'title'=>'Gerar Comprovante de Inscrição', 'target'=>'_blank', 'href'=>"../gera_comprovante.php?freq={0}&origem=I"),
    "data_cadastro"       =>array("header"=>"Data Cadastro", "type"=>"label", "align"=>"center", 		"wrap"=>"wrap",   "text_length"=>"11", "case"=>"normal"),
	 "dt_alteracao"       =>array("header"=>"Data Alteração", "type"=>"label", "align"=>"center", "wrap"=>"wrap",   "text_length"=>"11", "case"=>"normal"),
    "nome"       =>array("header"=>"Nome", "type"=>"label", "align"=>"left", "wrap"=>"wrap",   "text_length"=>"20", "case"=>"normal"),
    "parcela" =>array("header"=>"Parcela",   "type"=>"label", "align"=>"center",  "wrap"=>"nowrap", "text_length"=>"30", "case"=>"normal"),
	 "validacao"  =>array("header"=>"Validado",      "type"=>"checkbox",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "sort_type"=>"numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>"S", "false_value"=>"N")
  );
  $dgrid->SetColumnsInViewMode($vm_colimns);
 ##  *** set auto-generated columns in view mode
 //  $auto_column_in_view_mode = false;
 // $dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);

 ## +---------------------------------------------------------------------------+
 ## | 7. Add/Edit/Details Mode Settings:                                        | 
 ## +---------------------------------------------------------------------------+
  ?>
<script type='text/javascript'>
function validaForm(){
	var vlr = document.getElementById('riynum_dias').value;		

if (vlr > 5) { 
	alert('Nº de dias transporte não pode ser superior a 5');
	document.getElementById("riynum_dias").value = 5;
	num_dias.focus();
	return false;
	}	else {	
	//limpar a DIV caso não tenha mais msg de erro
	// document.getElementById('erro').lastChild.data = "";
	 return true;
	}
}	
</script>
<?php
 ##  *** set add/edit mode table properties
    $em_table_properties = array("width"=>"75%");
    $dgrid->SetEditModeTableProperties($em_table_properties);
 ##  *** set details mode table properties
    $dm_table_properties = array("width"=>"60%");
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
 ##  ***  set settings for add/edit/details modes
    $table_name  = "frequencia";
    $primary_key = "id_frequencia";
    $condition   = "";
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
 ##  *** set columns in edit mode   
 /// $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
 date_default_timezone_set('America/Sao_Paulo');
$dt = date('d/m/Y');
$hr = date('H:i:s');
$data= explode("/",$dt);
	$data=$data[2]."-".$data[1]."-".$data[0];
$data = $data.' '.$hr;

    $em_columns = array(
	   "data_cadastro"        =>array("header"=>"Data Cadastro",       "type"=>"textbox",  "width"=>"340px", "req_type"=>"rt", "title"=>"Data Cadastro", "default"=>"$data", "readonly"=>true),	
	    "num_dias_trans"        =>array("header"=>"Nº Dias/Transporte",       "type"=>"textbox",  "width"=>"140px", "req_type"=>"si", "title"=>"Uso de transporte em Dias", 'on_js_event'=>'onBlur="return validaForm();"'),
		  "num_disciplinas"        =>array("header"=>"Nº Disciplinas",       "type"=>"textbox",  "width"=>"140px", "req_type"=>"si", "title"=>"Nº Disciplinas"),
       "id_pessoa"   =>array("header"=>"Estudante",     "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	   "id_parcela"   =>array("header"=>"Parcela",     "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	   "id_instituicao"   =>array("header"=>"Instituição",     "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	   "id_curso"   =>array("header"=>"Curso",     "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
	    "num_reprovacao"   =>array("header"=>"Nº Disciplinas Reprovadas",       "type"=>"textbox",  "width"=>"140px", "req_type"=>"si", "title"=>"Nº Disciplinas Reprovadas"),
    	"validacao"   =>array("header"=>"Validação",     "type"=>"checkbox", "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>"S", "false_value"=>"N")    
    );
    $dgrid->SetColumnsInEditMode($em_columns);
 ##  *** set auto-generated columns in edit mode
 //  $auto_column_in_edit_mode = false;
 //  $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
 ##  *** set foreign keys for add/edit/details modes (if there are linked tables)
    $foreign_keys = array(
     "id_pessoa" =>array("table"=>"pessoa", "field_key"=>"id_pessoa", "field_name"=>"concat(nome, ' ', sobrenome)", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"nome", "order_type"=>"ASC", "on_js_event"=>"onchange='_dgFormAction(\"\", \"\", \"".$unique_prefix."\", \"".$dgrid->HTTP_URL."\", \"".$_SERVER['QUERY_STRING']."\", \"".$postback."\", \"".$mode."\")'", "show_count"=>"true"),
	 
    "id_parcela" =>array("table"=>"parcela", "field_key"=>"id_parcela", "field_name"=>"concat(descricao,' - ',semestre,'/',ano)", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>("ativa='S'"), "order_by_field"=>"ano", "order_type"=>"DESC", "on_js_event"=>"onchange='_dgFormAction(\"\", \"\", \"".$unique_prefix."\", \"".$dgrid->HTTP_URL."\", \"".$_SERVER['QUERY_STRING']."\", \"".$postback."\", \"".$mode."\")'", "show_count"=>"true"),
	
	"id_instituicao" =>array("table"=>"instituicao", "field_key"=>"id_instituicao", "field_name"=>"instituicao", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"instituicao", "order_type"=>"ASC", "on_js_event"=>"onchange='_dgFormAction(\"\", \"\", \"".$unique_prefix."\", \"".$dgrid->HTTP_URL."\", \"".$_SERVER['QUERY_STRING']."\", \"".$postback."\", \"".$mode."\")'", "show_count"=>"true"),
	
	"id_curso" =>array("table"=>"curso", "field_key"=>"id_curso", "field_name"=>"curso", "view_type"=>"dropdownlist", "elements_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"curso", "order_type"=>"ASC", "on_js_event"=>"onchange='_dgFormAction(\"\", \"\", \"".$unique_prefix."\", \"".$dgrid->HTTP_URL."\", \"".$_SERVER['QUERY_STRING']."\", \"".$postback."\", \"".$mode."\")'", "show_count"=>"true"),
   ); 
   
   
   $dgrid->SetForeignKeysEdit($foreign_keys);

?>

<?php
################################################################################   
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** bind the DataGrid and draw it on the screen
  $dgrid->Bind();        
  ob_end_flush();

################################################################################   

function my_format_date($last_login_time){
    $last_login = mktime(substr($last_login_time, 11, 2), substr($last_login_time, 14, 2),
                        substr($last_login_time, 17, 2), substr($last_login_time, 5, 2),
                        substr($last_login_time, 8, 2), substr($last_login_time, 0, 4));
    if($last_login_time != ""){
        return date("M d, Y g:i A", $last_login);
        //return substr(0, 4);
    }else return "";
}
?>
