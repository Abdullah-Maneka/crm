<?php

try {
    $db = db_connect('default');
    $dbprefix = $db->getPrefix();

    $upgrade_sql = "upgrade-2.9.sql";
    $sql = file_get_contents($upgrade_sql);

    if ($dbprefix) {
        $sql = str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `' . $dbprefix, $sql);
        $sql = str_replace('INSERT INTO `', 'INSERT INTO `' . $dbprefix, $sql);
        $sql = str_replace('ALTER TABLE `', 'ALTER TABLE `' . $dbprefix, $sql);
        $sql = str_replace('DELETE FROM `', 'DELETE FROM `' . $dbprefix, $sql);
    }

    foreach (explode(";#", $sql) as $query) {
        $query = trim($query);
        if ($query) {
            try {
                $db->query($query);
            } catch (\Exception $ex) {
			
				log_message("error", $ex->getTraceAsString());
     
            }
        }
    }

    unlink($upgrade_sql);

    
    $enabled_users_settings = $this->Events_model->get_integrated_users_with_google_calendar()->getResult();

    foreach ($enabled_users_settings as $setting) {
        $user_id = $setting->setting_name;
        $user_id = explode("_", $user_id);
        $user_id = get_array_value($user_id, 1);

        if ($user_id && get_setting('user_' . $user_id . '_google_client_id') && get_setting('user_' . $user_id . '_google_client_secret') && get_setting('user_' . $user_id . '_oauth_access_token') && get_setting('user_' . $user_id . '_google_calendar_authorized')) {

            //check user's deleted status
            $user_options = array("id" => $user_id);
            $user_info = $this->Users_model->get_details($user_options)->getRow();
            if (!$user_info->id) {
                continue;
            }
            //add this user's email
            $this->Settings_model->save_setting('user_' . $user_id . '_google_calendar_gmail', $user_info->email);
        }
    }
    
    
    
    
} catch (\Exception $exc) {
	log_message("error", $exc->getTraceAsString());
}