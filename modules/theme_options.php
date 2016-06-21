<?php
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page(
            'Settings Admin', 
            'Site Config', 
            'manage_options', 
            'theme-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'theme_options' );
        ?>
        <div class="wrap">
            <h2>Site Config</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'analytics_option_group' );   
                do_settings_sections( 'theme-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'analytics_option_group', // Option group
            'theme_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        //section one

        add_settings_section(
            'sectionID', // ID
            'Analytics', // Title
            null,
            'theme-setting-admin' // Page
        );  

        add_settings_field(
            'gaID', // ID
            'GA ID', // Title 
            array( $this, 'ga_callback' ), // Callback
            'theme-setting-admin', // Page
            'sectionID' // Section           
        );      

        add_settings_field(
            'optimizelyID', 
            'Optimizely ID', 
            array( $this, 'optimizely_callback' ), 
            'theme-setting-admin', 
            'sectionID'
        );

        // section two  
        add_settings_section(
            'fonts', // ID
            'Fonts', // Title
            null,
            'theme-setting-admin' // Page
        );
        add_settings_field(
            'typekit', 
            'Typekit ID', 
            array( $this, 'typekit_callback' ), 
            'theme-setting-admin', 
            'fonts'
        );
        add_settings_field(
            'googlefont', 
            'Google Font', 
            array( $this, 'googlefont_callback' ), 
            'theme-setting-admin', 
            'fonts'
        );

         // section two  
        add_settings_section(
            'logo', // ID
            'Appearance', // Title
            null,
            'theme-setting-admin' // Page
        );
        add_settings_field(
            'logo', 
            'Logo', 
            array( $this, 'logo_callback' ), 
            'theme-setting-admin', 
            'logo'
        );
        //section 3
         add_settings_section(
            'niche', // ID
            'Niche', // Title
            null,
            'theme-setting-admin' // Page
        );
        add_settings_field(
            'nichename', 
            'Niche Name', 
            array( $this, 'nichename_callback' ), 
            'theme-setting-admin', 
            'niche'
        );
        add_settings_field(
            'nichepower', 
            'Niche Power', 
            array( $this, 'nichepower_callback' ), 
            'theme-setting-admin', 
            'niche'
        );
         add_settings_section(
            'ratings', // ID
            'Ratings', // Title
            null,
            'theme-setting-admin' // Page
        );
        add_settings_field(
            'rating', 
            'Denominator', 
            array( $this, 'ratings_callback' ), 
            'theme-setting-admin', 
            'ratings'
        );  
         // section two  
        add_settings_section(
            'company', // ID
            'Company', // Title
            null,
            'theme-setting-admin' // Page
        );
        add_settings_field(
            'phone', 
            'Phone Number', 
            array( $this, 'phone_callback' ), 
            'theme-setting-admin', 
            'company'
        );
        add_settings_field(
            'secure-url', 
            'Secure URL', 
            array( $this, 'secure_url_callback' ), 
            'theme-setting-admin', 
            'company'
        );
        add_settings_field(
            'cart-slug', 
            'Cart Slug', 
            array( $this, 'cart_slug_callback' ), 
            'theme-setting-admin', 
            'company'
        );
        add_settings_field(
            'cart-sbt', 
            'Cart Merchant Id', 
            array( $this, 'cart_sbt_callback' ), 
            'theme-setting-admin', 
            'company'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['gaID'] ) )
            $new_input['gaID'] = sanitize_text_field( $input['gaID'] );

        if( isset( $input['optimizelyID'] ) )
            $new_input['optimizelyID'] = sanitize_text_field( $input['optimizelyID'] );

        if( isset( $input['typekit'] ) )
            $new_input['typekit'] = sanitize_text_field( $input['typekit'] );
        if( isset( $input['googlefont'] ) )
            $new_input['googlefont'] = sanitize_text_field( $input['googlefont'] );
        if( isset( $input['logo'] ) )
            $new_input['logo'] = sanitize_text_field( $input['logo'] );

        if( isset( $input['nichename'] ) )
            $new_input['nichename'] = sanitize_text_field( $input['nichename'] );

        if( isset( $input['nichepower'] ) )
            $new_input['nichepower'] = sanitize_text_field( $input['nichepower'] );

        if( isset( $input['ratings'] ) )
            $new_input['ratings'] = sanitize_text_field( $input['ratings'] );
        
        if( isset( $input['phone'] ) )
            $new_input['phone'] = sanitize_text_field( $input['phone'] );

        if( isset( $input['secure-url'] ) )
            $new_input['secure-url'] = sanitize_text_field( $input['secure-url'] );

        if( isset( $input['cart-slug'] ) )
            $new_input['cart-slug'] = sanitize_text_field( $input['cart-slug'] );

        if( isset( $input['cart-sbt'] ) )
            $new_input['cart-sbt'] = sanitize_text_field( $input['cart-sbt'] );

        return $new_input;
    }

    /** 
     * Get the settings option array and print one of its values
     */


    public function ga_callback()
    {
        printf(
            '<input type="text" id="gaID" name="theme_options[gaID]" value="%s" />',
            isset( $this->options['gaID'] ) ? esc_attr( $this->options['gaID']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function optimizely_callback()
    {
        printf(
            '<input type="text" id="optimizelyID" name="theme_options[optimizelyID]" value="%s" />',
            isset( $this->options['optimizelyID'] ) ? esc_attr( $this->options['optimizelyID']) : ''
        );
    }

    public function typekit_callback()
    {
        printf(
            '<input type="text" id="typekit" name="theme_options[typekit]" value="%s" /> Add name of .js file',
            isset( $this->options['typekit'] ) ? esc_attr( $this->options['typekit']) : ''
        );
    }

    public function googlefont_callback()
    {
        printf(
            '<input type="text" id="googlefont" name="theme_options[googlefont]" value="%s" /> Add string after family=',
            isset( $this->options['googlefont'] ) ? esc_attr( $this->options['googlefont']) : ''
        );
    }
    public function logo_callback()
    {
        printf(
            '<input type="text" id="logo" name="theme_options[logo]" value="%s" />',
            isset( $this->options['logo'] ) ? esc_attr( $this->options['logo']) : ''
        );
    }
    public function nichename_callback()
    {
        printf(
            '<input type="text" id="nichename" name="theme_options[nichename]" value="%s" />',
            isset( $this->options['nichename'] ) ? esc_attr( $this->options['nichename']) : ''
        );
    }
    public function nichepower_callback()
    {
        printf(
            '<input type="text" id="nichepower" name="theme_options[nichepower]" value="%s" />',
            isset( $this->options['nichepower'] ) ? esc_attr( $this->options['nichepower']) : ''
        );
    }
    public function ratings_callback()
    {
        printf(
            'Out of / <input type="number" step="any" id="ratings" name="theme_options[ratings]" value="%s" />',
            isset( $this->options['ratings'] ) ? esc_attr( $this->options['ratings']) : ''
        );
    }
    public function phone_callback()
    {
        printf(
            '<input type="text" name="theme_options[phone]" value="%s" />',
            isset( $this->options['phone'] ) ? esc_attr( $this->options['phone']) : ''
        );
    }
    public function cart_slug_callback()
    {
        printf(
            '<input type="text" name="theme_options[cart-slug]" value="%s" />',
            isset( $this->options['cart-slug'] ) ? esc_attr( $this->options['cart-slug']) : ''
        );
    }
    public function secure_url_callback()
    {
        printf(
            '<input type="text" name="theme_options[secure-url]" value="%s" />',
            isset( $this->options['secure-url'] ) ? esc_attr( $this->options['secure-url']) : ''
        );
    }
    public function cart_sbt_callback()
    {
        printf(
            '<input type="text" name="theme_options[cart-sbt]" value="%s" />',
            isset( $this->options['cart-sbt'] ) ? esc_attr( $this->options['cart-sbt']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();