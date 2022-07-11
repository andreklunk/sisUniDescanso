<?php
//------------------------------------------------------------------------------             
//*** Thai (th) 
//------------------------------------------------------------------------------
function setLanguageTh(){ 
    $lang['='] = "=";  // "equal";
    $lang['!='] = "!="; // "not equal"; 
    $lang['>'] = ">";  // "bigger"; 
    $lang['>='] = ">=";  // "bigger or equal";
    $lang['<'] = "<";  // "smaller";            
    $lang['<='] = "<=";  // "smaller or equal";            
    $lang['add'] = "เพิ่ม"; 
    $lang['add_new'] = "+ เพิ่มใหม่"; 
    $lang['add_new_record'] = "เพิ่มเรคอร์ดใหม่";
    $lang['add_new_record_blocked'] = "มาตรการรักษาความปลอดภัย: พยายามสร้างเรคอร์ดใหม่! กรุณาตรวจสอบการตั้งค่า, ไม่อนุญาติให้ดำเนินการได้!";    
    $lang['adding_operation_completed'] = "ดำเนินการเพิ่มข้อมูล เรียบร้อย!";
    $lang['adding_operation_uncompleted'] = "ดำเนินการเพิ่มข้อมูล ไม่สำเร็จ!";
    $lang['alert_perform_operation'] = "คุณต้องการดำเนินการต่อใช่ไหม?";
    $lang['alert_select_row'] = "คุณต้องเลือกแถวใดๆ เพื่อดำเนินการต่อ!";    
    $lang['and'] = "และ";
    $lang['any'] = "ใด";                                                 
    $lang['ascending'] = "น้อยไปมาก"; 
    $lang['back'] = "กลับ"; 
    $lang['cancel'] = "ยกเลิก";
    $lang['cancel_creating_new_record'] = "คุณต้องการยกเลิกการสร้างแถวใหม่?";
    $lang['check_all'] = "ตรวจสอบทั้งหมด";    
    $lang['clear'] = "ล้าง";    
    $lang['click_to_download'] = "คลิกที่นี่เพื่อดาวน์โหลด";
    $lang['clone_selected'] = "โคลนที่เลือก";
    $lang['cloning_record_blocked'] = "ตรวจสอบความปลอดภัย: ความพยายามในการโคลนบันทึก! ตรวจสอบการตั้งค่าของการดำเนินการไม่ได้รับอนุญาต!";
    $lang['cloning_operation_completed'] = "การดำเนินการโคลนเสร็จเรียบร้อยแล้ว!";
    $lang['cloning_operation_uncompleted'] = "การดำเนินงานที่ยังไม่เสร็จโคลน!";
    $lang['create'] = "สร้าง"; 
    $lang['create_new_record'] = "สร้างเรคอร์ดใหม่"; 
    $lang['current'] = "ปัจจุบัน"; 
    $lang['delete'] = "ลบข้อมูล"; 
    $lang['delete_record'] = "ลบเรคอร์ด";
    $lang['delete_record_blocked'] = "มาตรการรักษาความปลอดภัย: พยายามลบเรคอร์ด! กรุณาตรวจสอบการตั้งค่า, ไม่อนุญาติให้ดำเนินการได้!";    
    $lang['delete_selected'] = "ลบรายการที่เลือก";
    $lang['delete_selected_records'] = "คุณต้องการลบเรคอร์ดที่เลือก?";
    $lang['delete_this_record'] = "คุณต้องการลบเรคอร์ดนี้?";                                 
    $lang['deleting_operation_completed'] = "ดำเนินการลบข้อมูล เรียบร้อย!";
    $lang['deleting_operation_uncompleted'] = "ดำเนินการลบข้อมูล ไม่สำเร็จ!";                                    
    $lang['descending'] = "มากไปน้อย";
    $lang['details'] = "รายละเอียด";
    $lang['details_selected'] = "ดูรายการที่เลือก";            
    $lang['download'] = "ดาวน์โหลด";
    $lang['edit'] = "แก้ไข";
    $lang['edit_selected'] = "แก้ไขรายการที่เลือก";
    $lang['edit_record'] = "แก้ไขเรคอร์ด"; 
    $lang['edit_selected_records'] = "คุณต้องการแก้ไขเรคอร์ดที่เลือก?";               
    $lang['errors'] = "ข้อผิดพลาด";            
    $lang['export_to_excel'] = "ส่งออกเป็น Excel";
    $lang['export_to_pdf'] = "ส่งออกเป็น PDF";    
    $lang['export_to_word'] = "ส่งออกเป็น Word";
    $lang['export_to_xml'] = "ส่งออกเป็น XML";
    $lang['export_message'] = "<label class=\"default_df_label\">ไฟล์  _FILE_ พร้อมแล้ว. หลังจากดาวน์โหลดเสร็จ,</label> <a class=\"default_df_error_message\" href=\"javascript: window.close();\">กรุณาปิดหน้าต่างนี้</a>.";
    $lang['field'] = "ฟีลด์"; 
    $lang['field_value'] = "ค่าของฟีลด์";
    $lang['file_find_error'] = "ไม่พบไฟล์: <b>_FILE_</b>. <br>ตรวจสอบให้แน่ใจว่ามีไฟล์นี้หรือตั้งค่า PATH ให้ถูกต้อง!";                                    
    $lang['file_opening_error'] = "ไม่สามารถเปิดไฟล์ได้. กรุณาตรวจสอบสิทธิ์ในการอ่านไฟล์.";
    $lang['file_extension_error'] = 'เกิดข้อผิดหลาดในการอัพโหลด: ไม่อนุญาติให้อัพโหลด:ไฟล์นามสกุลดังกล่าว. กรุณาเลือกไฟล์แบบอื่น.';
    $lang['file_writing_error'] = "ไม่สามารถเขียนไฟล์. กรุณาตรวจสอบว่าระบบมีสิทธิ์ในการเขียนไฟล์!";
    $lang['file_invalid_file_size'] = "ขนาดของไฟล์เหมาะสม";
    $lang['file_uploading_error'] = "เกิดข้อผิดพลาดในขณะอัพโหลดไฟล์, กรุณาลองใหม่อีกครั้ง!";
    $lang['file_deleting_error'] = "เกิดข้อผิดพลาดในการลบไฟล์!";
    $lang['first'] = "ลำดับแรก";
    $lang['format'] = "รูป";
    $lang['generate'] = "สร้าง";
    $lang['handle_selected_records'] = "คุณแน่ใจหรือว่าต้องการที่จะจัดการระเบียนที่เลือก?";
    $lang['hide_search'] = "ซ่อนการค้นหา";
    $lang['item'] = "item";
    $lang['items'] = "items";
    $lang['last'] = "ลำดับสุดท้าย";
    $lang['like'] = "like";
    $lang['like%'] = "like%";  // "begins with"; 
    $lang['%like'] = "%like";  // "ends with";
    $lang['%like%'] = "%like%";  
    $lang['loading_data'] = "กำลังดึงข้อมูล...";
    $lang['max'] = "max";                
    $lang['max_number_of_records'] = "คุณได้เกินจำนวนสูงสุดของระเบียนอนุญาต!";
    $lang['move_down'] = "ย้ายลง";
    $lang['move_up'] = "ผลุบโผล่";
    $lang['move_operation_completed'] = "การดำเนินการย้ายแถวเสร็จเรียบร้อยแล้ว!";
    $lang['move_operation_uncompleted'] = "การดำเนินการย้ายแถวค้าง!";    
    $lang['next'] = "ถัดไป";
    $lang['no'] = "No";                                
    $lang['no_data_found'] = "ไม่พบข้อมูล"; 
    $lang['no_data_found_error'] = "ไม่พบข้อมูล! กรุณาตรวจสอบไวยากรณ์อย่างระมัดระวัง!<br>อาจเป็นเพราะอักษรตัวเล็กตัวใหญ่หรือสัญลักษณ์อื่นๆ ที่แหรกเข้ามา.";                                
    $lang['no_image'] = "ไม่พบภาพ";
    $lang['not_like'] = "not like";
    $lang['of'] = "จาก";
    $lang['operation_was_already_done'] = "การดำเนินการเสร็จสิ้นไปแล้ว! คุณไม่สามารถทำซ้ำอีกได้.";            
    $lang['or'] = "or";                
    $lang['pages'] = "หน้า";                    
    $lang['page_size'] = "จำนวนหน้า";
    $lang['previous'] = "ก่อนหน้า";                
    $lang['printable_view'] = "มุมมองก่อนพิมพ์";
    $lang['print_now'] = "พิมพ์ทันที";
    $lang['print_now_title'] = "คลิ้กที่นี้เพื่อพิมพ์หน้าปัจจุบัน";
    $lang['record_n'] = "เรคอร์ด #";
    $lang['refresh_page'] = "รีเฟร์ชหน้านี้";
    $lang['remove'] = "เอาออก";
    $lang['reset'] = "รีเซ็ต";                        
    $lang['results'] = "ผลลัพธ์";
    $lang['required_fields_msg'] = "<span style='color:#cd0000'>*</span> ต้องกรอกรายการที่มีเครื่องหมายดอกจันทร์ *";
    $lang['search'] = "ค้นหา"; 
    $lang['search_d'] = "ค้นหา"; // (description) 
    $lang['search_type'] = "ประเภทการค้นหา"; 
    $lang['select'] = "เลือก";
    $lang['set_date'] = "เลือกวันที่";
    $lang['sort'] = "จัดเรียง";        
    $lang['test'] = "ทดสอบ";
    $lang['total'] = "ทั้งสิ้น";
    $lang['turn_on_debug_mode'] = "กรุณาเปิด debug mode เพื่อดูข้อมูลเพิ่มเติม";
    $lang['uncheck_all'] = "ไม่เลือกทั้งหมด";
    $lang['unhide_search'] = "ยกเลิกการซ่อนการค้นหา";
    $lang['unique_field_error'] = "ฟีลด์ _FIELD_ อนุญาติให้ใส่ข้อมูลที่ไม่ซ้ำกัน - กรุณากรอกข้อมูลใหม่อีกครั้ง!";            
    $lang['update'] = "อัพเดท"; 
    $lang['update_record'] = "อัพเดทเรคอร์ด";
    $lang['update_record_blocked'] = "มาตรการรักษาความปลอดภัย: พยายามอัพเดทเรคอร์ด! กรุณาตรวจสอบการตั้งค่า, ไม่อนุญาติให้ดำเนินการได้!";    
    $lang['updating_operation_completed'] = "ดำเนินการอัพเดทข้อมูล เรียบร้อย!";
    $lang['updating_operation_uncompleted'] = "ดำเนินการอัพเดทข้อมูล ไม่สำเร็จ!";                        
    $lang['upload'] = "อัพโหลด";
    $lang['uploaded_file_not_image'] = "ไฟล์ที่อัปโหลดไม่ได้ดูเหมือนจะเป็นภาพ";
    $lang['view'] = "แสดง"; 
    $lang['view_details'] = "แสดงรายละเอียด";
    $lang['warnings'] = "เตือน";
    $lang['with_selected'] = "กับข้อมูลที่เลือก";
    $lang['wrong_field_name'] = "ชื่อฟีลด์ไม่ถูกต้อง";
    $lang['wrong_parameter_error'] = "พารามิเตอร์ไม่ถูกต้อง ใน [<b>_FIELD_</b>]: _VALUE_";
    $lang['yes'] = "ตกลง";                

    // date-time
    $lang['day']    = "วัน";
    $lang['month']  = "เดือน";
    $lang['year']   = "ปี";
    $lang['hour']   = "ชั่วโมง";
    $lang['min']    = "นาที";
    $lang['sec']    = "วินาที";
    $lang['months'][1] = "มกราคม";
    $lang['months'][2] = "กุมภาพันธ์";
    $lang['months'][3] = "มีนาคม";
    $lang['months'][4] = "เมษายน";
    $lang['months'][5] = "พฤษภาคม";
    $lang['months'][6] = "มิถูนายน";
    $lang['months'][7] = "กรกฎาคม";
    $lang['months'][8] = "สิงหาคม";
    $lang['months'][9] = "กันยายน";
    $lang['months'][10] = "ตุลาคม";
    $lang['months'][11] = "พฤศจิกายน";
    $lang['months'][12] = "ธันวาคม";
    
    return $lang;
}
?>