<?php
    //DADOS PARA CONEXÃO
	include_once('conexao.php');
    $usuario = $DB_USER;
    $senha = $DB_PASS;
    $dbname = $DB_NAME;
	$host = $DB_HOST;
    // use true se quiser remover caracteres que não sejam utf-8
    $checkUtf = true;
    
// conectando ao banco
   // mysql_connect($host, $usuario, $senha) or die(mysql_error());
   // mysql_select_db($dbname) or die(mysql_error());

// gerando um arquivo sql. Como?
// a função fopen, abre um arquivo, que no meu caso, será chamado como: nomedobanco.sql
// note que eu estou concatenando dinamicamente o nome do banco com a extensão .sql.
    $back = fopen($dbname . ".sql", "w");

// aqui, listo todas as tabelas daquele banco selecionado acima
    $res = mysqli_query($link,"SHOW TABLES FROM $dbname") or die(mysqli_error($link));

    // ultra importante para não dar erro nos primeiros inserts
    // principalmente de usar InnoDB e relacionar as tabelas
    fwrite($back, "set foreign_key_checks=0;\n\n");
    
    // regex para ver se o char é UTF-8
    // Link: http://stackoverflow.com/questions/1401317/remove-non-utf8-characters-from-string
    $regex1 = <<<'END'
/
  ( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
  | [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
  | [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
  | [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
  )
| .                             # anything else
/x
END;
    
// resgato cada uma das tabelas, num loop
    while ($row = mysqli_fetch_row($res)) 
    {
        $table = $row[0];
		
// usando a função SHOW CREATE TABLE do mysql, exibo as funções de criação da tabela,
// exportando também isso, para nosso arquivo de backup
        $res2 = mysqli_query($link,"SHOW CREATE TABLE $table");
// digo que o comando acima deve ser feito em cada uma das tabelas
        while ($lin = mysqli_fetch_row($res2)) {
// instruções que serão gravadas no arquivo de backup
            fwrite($back, "\n#\n# //Criação da Tabela : $table\n#\n\n");
            fwrite($back, "$lin[1] ;\n\n#\n# //Dados a serem incluídos na tabela\n#\n\n");

// seleciono todos os dados de cada tabela pega no while acima
// e depois gravo no arquivo .sql, usando comandos de insert
            $res3 = mysqli_query($link,"SELECT * FROM $table");
            $first = true;
            while ($r = mysqli_fetch_row($res3)) 
            {
                if ($first)
                {
                    $sql = "INSERT INTO $table VALUES ";
                    $first = false;
                }
                else
                {
                    $sql .= ',';
                }
                
                
                $sql .= "('";
                
                $imploded = '';
                
                $firstImplode = true;
                
                foreach ($r as $reg) 
                {
                    if ($firstImplode)
                    {
                        $firstImplode = false;
                    }
                    else
                    {
                        $imploded .= "', '";
                    }
                    
                    if ($checkUtf)
                    {
                        $escaped = str_replace('\'', "\\'", str_replace('\\', "\\\\", preg_replace($regex1, '$1', $reg)));
                    }
                    else 
                    {
                        $escaped = str_replace('\'', "\\'", str_replace('\\', "\\\\", $reg));
                    }
                    $imploded .= $escaped;
                }
                
                $sql .= $imploded;
                
                $sql .= "')\n";

            }
            if (!$first)
            {
                $sql .= ";\n";
                fwrite($back, $sql);
            }
        }
    }

// fechar o arquivo que foi gravado
    fclose($back);
// gerando o arquivo para download, com o nome do banco e extensão sql.
    $arquivo = $dbname . ".sql";
    Header("Content-type: application/sql");
    Header("Content-Disposition: attachment; filename=$arquivo");
// lê e exibe o conteúdo do arquivo gerado
    readfile($arquivo);
?>