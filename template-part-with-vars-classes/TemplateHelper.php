<?php

namespace JPR\TemplatePartWithVars;

class Helper
{
    /**
     * @see wp-includes/general-template.php:146 for standard WP implementation
     *
     * @param       $slug
     * @param null $name
     * @param array $namedVariables
     * @throws \Exception
     */
    public static function getTemplatePartWithNamedVariables($slug, $name = null, array $namedVariables = [])
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

        foreach ($namedVariables as $variableName => $value) {
            if (!self::isVariableNameValid($variableName)) {
                trigger_error('Variable names must be valid. Skipping "' . $variableName . '" because it is not a valid variable name.');
                continue;
            }

            if (isset($$variableName)) {
                trigger_error("$variableName already existed, probably set by WordPress, so it wasn't set to $value like you wanted. Instead it is set to: " . print_r($$variableName, true));
                continue;
            }

            $$variableName = $value;
        }

        require $template;
    }

    /**
     * Check if the provided $variableName is valid.
     *
     * @param $variableName
     * @return bool
     */
    private static function isVariableNameValid($variableName)
    {
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_\x7f-\xff]*/', $variableName)) {
            return true;
        }

        return false;
    }
}