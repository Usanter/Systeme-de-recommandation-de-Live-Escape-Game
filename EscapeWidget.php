<?php
	class Escape_widget extends WP_Widget
	{
		public function __construct()
		{
			parent::__construct('ID_Recommandation_widget','Recommandation_Widget',array('description' => 'Un widget de système de recommandation'));	
		}

		public function widget($args,$instance)
		{
			echo apply_filters('widget_title', $instance['title']);
			//Display all the criteron on the widget
			?>
			<html>
			<script type="text/javascript" src="/scripts.js"></script>
				<table id="tab_critere">
					<tr>
						<td><label>Critères </label></td>
 						<td >Pas important</td>
 						<td >Important</td>
					</tr>
						<?php
						global $wpdb;

						$result = $wpdb->get_results( "SELECT Name FROM {$wpdb->prefix}system_recommandation_criteres");
						$i = 0;
                        foreach ( $result as $row ) 
						{
							?>
							<tr>
								<td><label><?php echo $row->Name ?></label></td>
		                		<td colspan="2"><input type="range" style="width:200px" id="<?php echo $i ?>ID" value="50" min="1" max="100" step ="0.1" oninput="<?php echo $i ?>Output.value = <?php echo $i ?>Input.value"></input> </td>
		                   </tr>
		                   <?php
		                   $i += 1;
						}
						?>
    			</table>
				<form>
				  <div class="multiselect">
				    <div class="selectBox" onclick="showCheckboxes()">
				      <select>
				        <option>Selectionnez vos thèmes</option>
				      </select>
				      <div class="overSelect"></div>
				    </div>
				    <div id="checkboxes">
				    <table id="tab_theme">
				    <?php
						global $wpdb;
						$result = $wpdb->get_results( "SELECT Name FROM {$wpdb->prefix}system_recommandation_themes");
						$i = 0;
                        foreach ($result as $theme) {
						?>
						<tr><td>
							<label for="<?php echo $i ?>">
				        	<input type="checkbox" id="<?php echo $i ?>theme" value="<?php echo utf8_encode($theme->Name) ?>" onclick="close_menu_deroulant()"/><?php echo $theme->Name ?></label></td></tr>
		                   <?php
		                   $i += 1;
						}
						?>
						</table>
				    </div>
				  </div>
				</form>
    			<table id="tab_expertise">
					<tr>
						<td>expertise</td>
						<td><input type="range" style="width:200px" id="id_expertise" value="50" min="1" max="100" step ="0.1" oninput="<?php echo $i ?>Output.value = <?php echo $i ?>Input.value"></input></td>
					</tr>   				
    			</table>
    			<div style="text-align:center"> <input type="submit" value="Lancer la recherche" onclick="launch_amas_requete('<?php echo plugins_url();?>')"/> </div> 
    			<!-- tableau des résultats caché à l'instanciation-->
    			<div style="visibility: hidden; display: none" id="div_results_2">
	    			<p>Suggestions: </p> 
	    		</div>
	    		<div>
	    			<table id="tab_res">
	    				<!-- Salle / Note / Choix / lien (toujours caché) -->
	    				<tr id="res" style="visibility: hidden; display: none">
	    					<td style="text-align:left;">Salle </td>
	    					<td style="text-align:center"> Score </td>
	    					<td style="text-align:right;">choisir</td>
	    				</tr>
	    				<tr id="res_1" style="visibility: hidden; display: none">
	    					<td style="text-align:left;" id="nomSalle_1"></td>
	    					<td style="text-align:center" id="note_1"></td>
	    					<!-- bouton, onclick ouvre la page du lien associé à sa ligne -->
	    					<td style="text-align:right;"><input type="radio" name="radio_buton_choice" value="choix 1" checked="checked"/></td>
	    					<!-- lien, et idSalle toujours caché -->
	    					<td style="visibility: hidden; display: none" id="lien_1"></td>
	    					<td style="visibility: hidden; display: none" id="idSalle_1"></td>
	    				</tr>
	    				<tr id="res_2" style="visibility: hidden; display: none">
	    					<td style="text-align:left;" id="nomSalle_2"></td>
	    					<td style="text-align:center" id="note_2"></td>
	    					<!-- bouton, onclick ouvre la page du lien associé à sa ligne -->
	    					<td style="text-align:right;"><input type="radio" name="radio_buton_choice" value="choix 2"/></td>
	    					<!-- lien, et idSalle toujours caché -->
	    					<td style="visibility: hidden; display: none" id="lien_2"></td>
	    					<td style="visibility: hidden; display: none" id="idSalle_2"></td>
	    				</tr>
	    				<tr id="res_3" style="visibility: hidden; display: none">
	    					<td style="text-align:left;" id="nomSalle_3"></td>
	    					<td style="text-align:center" id="note_3"></td>
	    					<!-- bouton, onclick ouvre la page du lien associé à sa ligne -->
	    					<td style="text-align:right;"><input type="radio" name="radio_buton_choice" value="choix 3"/></td>
	    					<!-- lien, et idSalle toujours caché -->
	    					<td style="visibility: hidden; display: none" id="lien_3"></td>
	    					<td style="visibility: hidden; display: none" id="idSalle_3"></td>
	    				</tr>
	    			</table>
	    		<div id="div_results" style="visibility: hidden; display: none">
	    			<p style="text-align:center;"><input type="submit" value="Choisir cette salle" onclick="launch_amas_feedback_choice('<?php echo plugins_url();?>')"/></p>
	    			<p id="retour_feedback"></p>
	    			<p id="loggeur"></p>
	    		</div>
			</html>
	    <?php
		}
		
		//Allows to define a title to the widget
		public function form($instance)
		{
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
			$title = sanitize_text_field( $instance['title'] );
			?>
			<p ><label  for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			<?php
		}
	}