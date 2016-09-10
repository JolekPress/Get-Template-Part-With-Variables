<?php

namespace JPR\TemplatePartWithVars;

class Helper
{
    /**
     * @see wp-includes/general-template.php:146 for standard WP implementation
     *
     * @param       $slug
     * @param null $name
     * @param array $named_variables
     * @throws \Exception
     */
    public static function get_template_part_with_named_variables($slug, $name = null, $named_variables = [])
    {
        // Taken from standard get_template_part function
        \do_action("get_template_part_{$slug}", $slug, $name);

        $templates = array();
        $name = (string)$name;
        if ('' !== $name)
            $templates[] = "{$slug}-{$name}.php";

        $templates[] = "{$slug}.php";

        $template = \locate_template($templates, false, false);

        if (empty($template)) {
            return;
        }

        // @see load_template (wp-includes/template.php) - these are needed for WordPress to work.
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if (is_array($wp_query->query_vars)) {
            \extract($wp_query->query_vars, EXTR_SKIP);
        }

        if (isset($s)) {
            $s = \esc_attr($s);
        }
        // End standard WordPress behavior

        foreach ($named_variables as $variable_name => $value) {
            if (!is_string($variable_name)) {
                continue;
            }

            if (isset($$variable_name)) {
                throw new \Exception("The variable '$variable_name' is already defined, probably by WordPress. Choose a different variable name.");
            }

            $$variable_name = $value;
        }

        require $template;
    }
}