<?php 
	include_once('EscapeWidget.php');
	include_once('FeedBackWidget.php');

	class Systeme_Recommandation
	{
		public function __construct()
		{
			//Initialization widget
			add_action('widgets_init',function(){register_widget('Escape_widget');});
			add_action('widgets_init',function(){register_widget('FeedBack_widget');});
		}

		//Creation of the table on the database 
		public static function install()
		{
		    global $wpdb;

		    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}system_recommandation_themes
					(
					ID int NOT NULL AUTO_INCREMENT,
					Name varchar(255) NOT NULL,
					PRIMARY KEY (ID)
					);");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_criteres
					(
					ID int NOT NULL 
					AUTO_INCREMENT,
					Name varchar(255) NOT NULL,
					PRIMARY KEY(ID)
					);");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_salles
					(
					ID int NOT NULL
					AUTO_INCREMENT,
					Name varchar(255) NOT NULL,
					lien varchar(255),
					theme varchar(516),
					PRIMARY KEY(ID)    
					);");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_notes
					(
					ID int NOT NULL
					AUTO_INCREMENT,
					note float NOT NULL 
					DEFAULT 50.0,
					id_critere INT,
					id_salle INT,
					FOREIGN KEY (id_critere)
					REFERENCES wp_system_recommandation_criteres(ID),
					FOREIGN KEY (id_salle)
					REFERENCES wp_system_recommandation_salles(ID),
					PRIMARY KEY(ID)
					)");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_log_feedback_choix
					(
					ID int NOT NULL AUTO_INCREMENT,
					id_salle INT,
					Date varchar(64) NOT NULL,
					IP varchar(64) NOT NULL,
					Modifications varchar(512),
					FOREIGN KEY (id_salle)
					REFERENCES wp_system_recommandation_salles(ID),
					PRIMARY KEY(ID)
					);");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_log_feedback_saisienotes
					(
					ID int NOT NULL AUTO_INCREMENT,
					id_salle INT,
					Date varchar(64) NOT NULL,
					IP varchar(64) NOT NULL,
					Modifications varchar(512),
					FOREIGN KEY (id_salle)
					REFERENCES wp_system_recommandation_salles(ID),
					PRIMARY KEY(ID)
					);");

					$wpdb->query("CREATE TABLE  IF NOT EXISTS {$wpdb->prefix}system_recommandation_configuration
					(
					ID int NOT NULL AUTO_INCREMENT,
					increment_feedback_choix float NOT NULL 
					DEFAULT 1.0,
					nb_max_feedback_choix_jour INT NOT NULL 
					DEFAULT 3,
					increment_feedback_saisienote float NOT NULL 
					DEFAULT 2.0,
					nb_max_feedback_saisienote_jour INT NOT NULL 
					DEFAULT 2,
					PRIMARY KEY(ID)
					);");

					/* inserer une configuration de base */
					$wpdb->insert("{$wpdb->prefix}system_recommandation_configuration", array('ID'=>NULL, 'increment_feedback_choix'=>1.0, 'nb_max_feedback_choix_jour'=>3, 'increment_feedback_saisienote'=>2.0, 'nb_max_feedback_saisienote_jour'=>2), array('%d','%f','%d','%f','%d'));
		}

		//Delet the table
		public static function uninstall()
		{
		    global $wpdb;

		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_notes;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_log_feedback_choix;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_log_feedback_saisienotes;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_salles;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_criteres;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_themes;");
		    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}system_recommandation_configuration;");
		}
	}