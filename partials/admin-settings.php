<?php
defined( "ABSPATH" ) || exit; // Exit if accessed directly
?>
<div class="wrap">
    <h1><?php esc_html_e("Autosuggest Email settings", "autosuggest-email"); ?></h1>
    <form method="post" action="options.php"> 
        <?php settings_fields("autosuggest-email-settings"); ?>
        <?php do_settings_sections("autosuggest-email-settings"); ?>        

        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <?php esc_html_e("Override email providers", "autosuggest-email"); ?><br />
                    <small><?php esc_html_e("One per row please", "autosuggest-email"); ?></small>
                </th>
                <td>
                    <textarea rows="10" cols="100" name="ase_email_providers"><?php echo esc_html(get_option("ase_email_providers")); ?></textarea><br />
                    <small><?php esc_html_e("Default:", "autosuggest-email"); ?> gmail, hotmail, yahoo, outlook, live, mail, icloud, web, comcast, siol</small>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <?php esc_html_e("Override email tlds", "autosuggest-email"); ?><br />
                    <small><?php esc_html_e("One per row please", "autosuggest-email"); ?></small>                    
                </th>
                <td>
                    <textarea rows="10" cols="100" name="ase_email_tlds"><?php echo esc_html(get_option("ase_email_tlds")); ?></textarea><br />
                    <small><?php esc_html_e("Default:", "autosuggest-email"); ?> com, com.au, com.tw, ca, co.nz, co.uk, de, fr, it, ru, net, org, edu, gov, jp, nl, kr, se, eu, ie, co.il, us, at, be, dk, hk, es, gr, ch, no, cz, in, net, net.au, info, biz, mil, co.jp, sg, hu, uk</small>
                </td>
            </tr>            
        </table>

        <?php submit_button(); ?>        
    </form>
</div>    
