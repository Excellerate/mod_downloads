<?php

class DownloadsHelperDatabase{

    static function save($data){

        // Find database prefix and pull all tables
        $app = JFactory::getApplication();
        $prefix = $app->getCfg('dbprefix');
        $tables = JFactory::getDbo()->getTableList();

        // Get database
        $db = JFactory::getDbo();

        // Build table if it does not exist
        if( ! in_array($prefix.'file_downloads', $tables) ){

            $db->setQuery(
                "CREATE TABLE IF NOT EXISTS `".$prefix."file_downloads` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(220) DEFAULT NULL,
                    `email` varchar(220) DEFAULT NULL,
                    `filename` text DEFAULT NULL,
                    `ip` varchar(11) NOT NULL,
                    `created_at` datetime NOT NULL,
                    `updated_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
            );

            $db->execute();
        }

        // Record the data
        $query = $db->getQuery(true);
        $columns = array('name', 'email', 'filename', 'ip', 'created_at', 'updated_at');
        $values = array(
            (isset($data['name']) ? $db->quote($data['name']) : "NULL"),
            (isset($data['email']) ? $db->quote($data['email']) : "NULL"),
            (isset($data['filename']) ? $db->quote($data['filename']) : "NULL"),
            $db->quote($_SERVER['REMOTE_ADDR']),
            $db->quote(date('Y-m-d H:i:s', time())),
            $db->quote(date('Y-m-d H:i:s', time()))
        );
        $query
            ->insert($db->quoteName($prefix.'file_downloads'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        $db->setQuery($query);
        $db->execute();

        // You may email this form
        return true;
    } 
}

?>