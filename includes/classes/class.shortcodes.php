<?php
if ( !defined('ABSPATH') )
    exit; // Exit if accessed directly

    /*
      CoursePress Shortcodes
     */

if ( !class_exists('CoursePress_Shortcodes') ) {

    class CoursePress_Shortcodes extends CoursePress {
        /* function CoursePress_Shortcodes() {
          $this->__construct();
          } */

        public static $instance = null;
        private $args = array();

        function __construct() {
//register plugin shortcodes
            add_shortcode('course_instructors', array( &$this, 'course_instructors' ));
            add_shortcode('course_instructor_avatar', array( &$this, 'course_instructor_avatar' ));
            add_shortcode('instructor_profile_url', array( &$this, 'instructor_profile_url' ));
            add_shortcode('course_details', array( &$this, 'course_details' ));
            add_shortcode('courses_student_dashboard', array( &$this, 'courses_student_dashboard' ));
            add_shortcode('courses_student_settings', array( &$this, 'courses_student_settings' ));
            add_shortcode('student_registration_form', array( &$this, 'student_registration_form' ));
            add_shortcode('courses_urls', array( &$this, 'courses_urls' ));
            add_shortcode('course_units', array( &$this, 'course_units' ));
            add_shortcode('course_units_loop', array( &$this, 'course_units_loop' ));
            add_shortcode('course_notifications_loop', array( &$this, 'course_notifications_loop' ));
            add_shortcode('course_discussion_loop', array( &$this, 'course_discussion_loop' ));
            add_shortcode('course_unit_single', array( &$this, 'course_unit_single' ));
            add_shortcode('course_unit_details', array( &$this, 'course_unit_details' ));
            add_shortcode('course_unit_archive_submenu', array( &$this, 'course_unit_archive_submenu' ));
            add_shortcode('course_breadcrumbs', array( &$this, 'course_breadcrumbs' ));
            add_shortcode('course_discussion', array( &$this, 'course_discussion' ));
            add_shortcode('get_parent_course_id', array( &$this, 'get_parent_course_id' ));
            add_shortcode('units_dropdown', array( &$this, 'units_dropdown' ));
            add_shortcode('course_list', array( &$this, 'course_list' ));
            add_shortcode('course_calendar', array( &$this, 'course_calendar' ));
            add_shortcode('course_featured', array( &$this, 'course_featured' ));
            add_shortcode('course_structure', array( &$this, 'course_structure' ));
            add_shortcode('module_status', array( &$this, 'module_status' ));
            add_shortcode('student_workbook_table', array( &$this, 'student_workbook_table' ));
            add_shortcode('course', array( &$this, 'course' ));
// Sub-shortcodes
            add_shortcode('course_title', array( &$this, 'course_title' ));
            add_shortcode('course_summary', array( &$this, 'course_summary' ));
            add_shortcode('course_description', array( &$this, 'course_description' ));
            add_shortcode('course_start', array( &$this, 'course_start' ));
            add_shortcode('course_end', array( &$this, 'course_end' ));
            add_shortcode('course_dates', array( &$this, 'course_dates' ));
            add_shortcode('course_enrollment_start', array( &$this, 'course_enrollment_start' ));
            add_shortcode('course_enrollment_end', array( &$this, 'course_enrollment_end' ));
            add_shortcode('course_enrollment_dates', array( &$this, 'course_enrollment_dates' ));
            add_shortcode('course_enrollment_type', array( &$this, 'course_enrollment_type' ));
            add_shortcode('course_class_size', array( &$this, 'course_class_size' ));
            add_shortcode('course_cost', array( &$this, 'course_cost' ));
            add_shortcode('course_language', array( &$this, 'course_language' ));
            add_shortcode('course_category', array( &$this, 'course_category' ));
            add_shortcode('course_list_image', array( &$this, 'course_list_image' ));
            add_shortcode('course_featured_video', array( &$this, 'course_featured_video' ));
            add_shortcode('course_join_button', array( &$this, 'course_join_button' ));
            add_shortcode('course_thumbnail', array( &$this, 'course_thumbnail' ));
            add_shortcode('course_media', array( &$this, 'course_media' ));
            add_shortcode('course_action_links', array( &$this, 'course_action_links' ));
//add_shortcode( 'unit_discussion', array( &$this, 'unit_discussion' ) );
// Page Shortcodes
            add_shortcode('course_signup', array( &$this, 'course_signup' ));

            $GLOBALS['units_breadcrumbs'] = '';
        }

        /**
         *
         * COURSE DETAILS SHORTCODES
         * =========================
         *
         */

        /**
         * Creates a [course] shortcode.
         *
         * This is just a wrapper shortcode for several other shortcodes.
         *
         * @since 1.0.0
         */
        function course( $atts ) {

            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'show' => 'summary',
                'date_format' => get_option('date_format'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'show_title' => 'no',
                            ), $atts, 'course'));

            $course = new Course($course_id);

// needs some more work...
// $encoded = object_encode( $course );
            $encoded = false;

            $sections = explode(',', $show);

            $content = '';

            foreach ( $sections as $section ) {
                $section = strtolower($section);
// [course_title]
                if ( 'title' == trim($section) && 'yes' == $show_title ) {
                    $content .= do_shortcode('[course_title title_tag="h3" course_id="' . $course_id . '" course_id="' . $course_id . '"]');
                }

// [course_summary]
                if ( 'summary' == trim($section) ) {
                    $content .= do_shortcode('[course_summary course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_description]
                if ( 'description' == trim($section) ) {
                    $content .= do_shortcode('[course_description course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_start]
                if ( 'start' == trim($section) ) {
                    $content .= do_shortcode('[course_start course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_end]
                if ( 'end' == trim($section) ) {
                    $content .= do_shortcode('[course_end course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_dates]
                if ( 'dates' == trim($section) ) {
                    $content .= do_shortcode('[course_dates course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_enrollment_start]
                if ( 'enrollment_start' == trim($section) ) {
                    $content .= do_shortcode('[course_enrollment_start course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_enrollment_end]
                if ( 'enrollment_end' == trim($section) ) {
                    $content .= do_shortcode('[course_enrollment_end course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_enrollment_dates]				
                if ( 'enrollment_dates' == trim($section) ) {
                    $content .= do_shortcode('[course_enrollment_dates course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '" course_id="' . $course_id . '"]');
                }

// [course_summary]
                if ( 'class_size' == trim($section) ) {
                    $content .= do_shortcode('[course_class_size course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_cost]
                if ( 'cost' == trim($section) ) {
                    $content .= do_shortcode('[course_cost course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_language]
                if ( 'language' == trim($section) ) {
                    $content .= do_shortcode('[course_language course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_category]
                if ( 'category' == trim($section) ) {
                    $content .= do_shortcode('[course_category course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_enrollment_type]
                if ( 'enrollment_type' == trim($section) ) {
                    $content .= do_shortcode('[course_enrollment_type course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_instructors]
                if ( 'instructors' == trim($section) ) {
                    $content .= do_shortcode('[course_instructors course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_list_image]
                if ( 'image' == trim($section) ) {
                    $content .= do_shortcode('[course_list_image course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_featured_video]
                if ( 'video' == trim($section) ) {
                    $content .= do_shortcode('[course_featured_video course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_join_button]
                if ( 'button' == trim($section) ) {
                    $content .= do_shortcode('[course_join_button course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_thumbnail]
                if ( 'thumbnail' == trim($section) ) {
                    $content .= do_shortcode('[course_thumbnail course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_action_links]
                if ( 'action_links' == trim($section) ) {
                    $content .= do_shortcode('[course_action_links course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_media]
                if ( 'media' == trim($section) ) {
                    $content .= do_shortcode('[course_media course="' . $encoded . '" course_id="' . $course_id . '"]');
                }

// [course_calendar]
                if ( 'calendar' == trim($section) ) {
                    $content .= do_shortcode('[course_calendar course="' . $encoded . '" course_id="' . $course_id . '"]');
                }
            }

            return $content;
        }

        /**
         * Shows the course title.
         *
         * @since 1.0.0
         */
        function course_title( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'title_tag' => 'h3',
                'link' => 'no',
                'class' => '',
                            ), $atts, 'course_title'));

            $title = get_the_title($course_id);

            ob_start();
            ?>
            <<?php echo $title_tag; ?> class="course-title course-title-<?php echo $course_id; ?> <?php echo $class; ?>">
            <?php echo 'yes' == $link ? '<a href="' . get_permalink($course_id) . '" title="' . $title . '">' : ''; ?>
            <?php echo $title; ?>
            <?php echo 'yes' == $link ? '</a>' : ''; ?>
            </<?php echo $title_tag; ?>>
            <?php
            $content = ob_get_clean();

// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course summary/excerpt.
         *
         * @since 1.0.0
         */
        function course_summary( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => '',
                'class' => '',
                'length' => ''
                            ), $atts, 'course_summary'));

            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            ob_start();
            ?>
            <div class="course-summary course-summary-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php
                if ( is_numeric($length) ) {
                    echo cp_length(do_shortcode($course->details->post_excerpt), $length);
                } else {
                    echo do_shortcode($course->details->post_excerpt);
                }
                ?>
            </div>
            <?php
            $content = ob_get_clean();

// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course description.
         *
         * @since 1.0.0
         */
        function course_description( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'class' => '',
                            ), $atts, 'course_description'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            ob_start();
            ?>
            <div class="course-description course-description-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php echo do_shortcode($course->details->post_content); ?>
            </div>
            <?php
            $content = ob_get_clean();

// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course start date.
         *
         * @since 1.0.0
         */
        function course_start( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Course Start Date', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'class' => '',
                            ), $atts, 'course_start'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $start_date = get_post_meta($course_id, 'course_start_date', true);
            ob_start();
            ?>
            <div class="course-start-date course-start-date-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo sp2nbsp(date($date_format, strtotime($start_date))); ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course end date.
         *
         * If the course has no end date, the no_date_text will be displayed instead of the date.
         *
         * @since 1.0.0
         */
        function course_end( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Course End Date', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_date_text' => __('No End Date', 'cp'),
                'class' => '',
                            ), $atts, 'course_end'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $end_date = get_post_meta($course_id, 'course_end_date', true);
            $open_ended = 'off' == get_post_meta($course_id, 'open_ended_course', true) ? false : true;
            ob_start();
            ?>
            <div class="course-end-date course-end-date-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo $open_ended ? $no_date_text : sp2nbsp(date($date_format, strtotime($end_date))); ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course start and end date.
         *
         * If the course has no end date, the no_date_text will be displayed instead of the date.		
         *
         * @since 1.0.0
         */
        function course_dates( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Course Dates', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_date_text' => __('No End Date', 'cp'),
                'alt_display_text' => __('Open-ended', 'cp'),
                'show_alt_display' => 'no',
                'class' => '',
                            ), $atts, 'course_dates'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $start_date = get_post_meta($course_id, 'course_start_date', true);
            $end_date = get_post_meta($course_id, 'course_end_date', true);
            $open_ended = 'off' == get_post_meta($course_id, 'open_ended_course', true) ? false : true;
            $end_output = $open_ended ? $no_date_text : sp2nbsp(date($date_format, strtotime($end_date)));
            $show_alt_display = 'no' == $show_alt_display || 'false' == $show_alt_display ? false : $show_alt_display;
            ob_start();
            ?>
            <div class="course-dates course-dates-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?><<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>><?php endif; ?>
                <?php if ( ( 'yes' == strtolower($show_alt_display) || $show_alt_display ) && $open_ended ) : ?><?php echo $alt_display_text; ?><?php else: ?><?php echo sp2nbsp(date($date_format, strtotime($start_date))) . ' - ' . $end_output; ?><?php endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the enrollment start date.
         *
         * If it is an open ended enrollment the no_date_text will be displayed.
         *
         * @since 1.0.0
         */
        function course_enrollment_start( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Enrollment Start Date', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_date_text' => __('Enroll Anytime', 'cp'),
                'class' => '',
                            ), $atts, 'course_enrollment_start'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $start_date = get_post_meta($course_id, 'enrollment_start_date', true);
            $open_ended = 'off' == get_post_meta($course_id, 'open_ended_enrollment', true) ? false : true;
            ob_start();
            ?>
            <div class="enrollment-start-date enrollment-start-date-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo $open_ended ? $no_date_text : sp2nbsp(date($date_format, strtotime($start_date))); ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the enrollment end date.
         *
         * By default this will not show for open ended enrollments.
         * Set show_all_dates="yes" to make it display.
         * If it is an open ended enrollment the no_date_text will be displayed.		
         *
         * @since 1.0.0
         */
        function course_enrollment_end( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Enrollment End Date', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_date_text' => __('Enroll Anytime', 'cp'),
                'show_all_dates' => 'no',
                'class' => '',
                            ), $atts, 'course_enrollment_end'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $end_date = get_post_meta($course_id, 'enrollment_end_date', true);
            $open_ended = 'off' == get_post_meta($course_id, 'open_ended_enrollment', true) ? false : true;
            ob_start();
            ?>
            <div class="enrollment-end-date enrollment-end-date-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo $open_ended ? $no_date_text : sp2nbsp(date($date_format, strtotime($end_date))); ?>				
            </div>
            <?php
            $content = '';
            if ( !$open_ended || 'yes' == $show_all_dates ) {
                $content = ob_get_clean();
            } else {
                ob_clean();
            }
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the enrollment start and end date.
         *
         * If it is an open ended enrollment the no_date_text will be displayed.
         *
         * @since 1.0.0
         */
        function course_enrollment_dates( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'date_format' => get_option('date_format'),
                'label' => __('Enrollment Dates', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_date_text' => __('Enroll Anytime', 'cp'),
                'alt_display_text' => __('Open-ended', 'cp'),
                'show_alt_display' => false,
                'class' => '',
                            ), $atts, 'course_enrollment_dates'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $start_date = get_post_meta($course_id, 'enrollment_start_date', true);
            $end_date = get_post_meta($course_id, 'enrollment_end_date', true);
            $open_ended = 'off' == get_post_meta($course_id, 'open_ended_enrollment', true) ? false : true;
            $show_alt_display = 'no' == $show_alt_display || 'false' == $show_alt_display ? false : $show_alt_display;
            ob_start();
            ?>
            <div class="enrollment-dates enrollment-dates-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?><<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>><?php endif; ?>
                <?php if ( ( 'yes' == strtolower($show_alt_display) || $show_alt_display ) && $open_ended ) : ?><?php echo $alt_display_text; ?><?php else: ?><?php echo $open_ended ? $no_date_text : sp2nbsp(date($date_format, strtotime($start_date))) . ' - ' . sp2nbsp(date($date_format, strtotime($end_date))); ?><?php endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course class size.
         *
         * If there is no limit set on the course nothing will be displayed.
         * You can make the no_limit_text display by setting show_no_limit="yes".
         *
         * By default it will show the remaining places,
         * turn this off by setting show_remaining="no".
         *
         * @since 1.0.0
         */
        function course_class_size( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'show_no_limit' => 'no',
                'show_remaining' => 'yes',
                'label' => __('Class Size', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_limit_text' => __('Unlimited', 'cp'),
                'remaining_text' => __('(%d places left)', 'cp'),
                'class' => '',
                            ), $atts, 'course_class_size'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $content = '';

            $is_limited = get_post_meta($course_id, 'limit_class_size', true) == 'on' ? true : false;
            $class_size = ( int ) get_post_meta($course_id, 'class_size', true);

            if ( $is_limited ) {
                $content .= $class_size;

                if ( 'yes' == $show_remaining ) {
                    $remaining = $class_size - $course->get_number_of_students();
                    $content .= ' ' . sprintf($remaining_text, $remaining);
                }
            } else {
                if ( 'yes' == $show_no_limit ) {
                    $content .= $no_limit_text;
                }
            }

            if ( !empty($content) ) {
                ob_start();
                ?>
                <div class="course-class-size course-class-size-<?php echo $course_id; ?> <?php echo $class; ?>">
                    <?php if ( !empty($label) ) : ?>
                        <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                    <?php endif; ?>
                    <?php echo $content; ?>
                </div>
                <?php
                $content = ob_get_clean();
            }
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course cost.
         *
         * @since 1.0.0
         */
        function course_cost( $atts ) {
            global $coursepress;

            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'label' => __('Price', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ': ',
                'no_cost_text' => __('FREE', 'cp'),
                'class' => '',
                            ), $atts, 'course_cost'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $is_paid = get_post_meta($course_id, 'paid_course', true) == 'on' ? true : false;

            $content = '';

            if ( $is_paid && CoursePress::instance()->marketpress_active ) {

                $mp_product = get_post_meta($course_id, 'marketpress_product', true);

                $content .= do_shortcode('[mp_product_price product_id="' . $mp_product . '" label=""]');
            } else {
                $content .= $no_cost_text;
            }

            if ( !empty($content) ) {
                ob_start();
                ?>
                <div class="course-cost course-cost-<?php echo $course_id; ?> <?php echo $class; ?>">
                    <?php if ( !empty($label) ) : ?><<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>><?php endif; ?><?php echo $content; ?>
                </div>
                <?php
                $content = ob_get_clean();
            }
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course language.
         *
         * @since 1.0.0
         */
        function course_language( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'label' => __('Course Language', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'class' => '',
                            ), $atts, 'course_language'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $language = get_post_meta($course_id, 'course_language', true);
            ob_start();
            ?>
            <?php if ( isset($language) && $language !== '' ) : ?>	
                <div class="course-language course-language-<?php echo $course_id; ?> <?php echo $class; ?>">
                    <?php if ( !empty($label) ) : ?>
                        <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                    <?php endif; ?>
                    <?php echo $language; ?>
                </div>
            <?php endif; ?>								
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course category.
         *
         * @since 1.0.0
         */
        function course_category( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'label' => __('Course Category', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'no_category_test' => __('None', 'cp'),
                'class' => '',
                            ), $atts, 'course_category'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $content = '';

            $categories = Course::get_categories($course_id);
            foreach ( $categories as $key => $category ) {
                $content .= $category->name;
                $content .= count($categories) - 1 < $key ? ', ' : '';
            }
// $category = get_category( $category );

            if ( !$categories || 0 == count($categories) ) {
                $content .= $no_category_text;
            }

            ob_start();
            ?>
            <div class="course-category course-category-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo $content; ?>
            </div>
            <?php
            $content = ob_get_clean();

// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows a friendly course enrollment type message.
         *
         * @since 1.0.0
         */
        function course_enrollment_type( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'label' => __('Who can Enroll?', 'cp'),
                'label_tag' => 'strong',
                'label_delimeter' => ':',
                'manual_text' => __('Students are added by instructors.', 'cp'),
                'prerequisite_text' => __('Students need to complete "%s" first.', 'cp'),
                'passcode_text' => __('A passcode is required to enroll.', 'cp'),
                'anyone_text' => __('Anyone', 'cp'),
                'class' => '',
                            ), $atts, 'course_enrollment_type'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $enrollment_type = get_post_meta($course_id, 'enroll_type', true);

            $content = '';

            switch ( $enrollment_type ) {
                case 'anyone':
                    $content = $anyone_text;
                    break;
                case 'passcode':
                    $content = $passcode_text;
                    break;
                case 'prerequisite':
                    $prereq = get_post_meta($course_id, 'prerequisite', true);
                    $pretitle = '<a href="' . get_permalink($prereq) . '">' . get_the_title($prereq) . '</a>';
                    $content = sprintf($prerequisite_text, $pretitle);
                    break;
                case 'manually':
                    $content = $manual_text;
                    break;
            }

            ob_start();
            ?>
            <div class="course-enrollment-type course-enrollment-type-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php if ( !empty($label) ) : ?>
                    <<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
                <?php endif; ?>
                <?php echo $content; ?>
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course list image.
         *
         * @since 1.0.0
         */
        function course_list_image( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'width' => 'default',
                'height' => 'default',
                'class' => '',
                            ), $atts, 'course_list_image'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $image_src = get_post_meta($course_id, 'featured_url', true);

            list( $img_w, $img_h ) = getimagesize($image_src);

// Note: by using both it usually reverts to the width
            $width = 'default' == $width ? $img_w : $width;
            $height = 'default' == $height ? $img_h : $height;

            ob_start();
            ?>
            <div class="course-list-image course-list-image-<?php echo $course_id; ?> <?php echo $class; ?>">
                <img width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $image_src; ?>" alt="<?php echo $course->details->post_title; ?>" title="<?php echo $course->details->post_title; ?>" />
            </div>
            <?php
            $content = ob_get_clean();
// Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course featured video.
         *
         * @since 1.0.0
         */
        function course_featured_video( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'width' => 'default',
                'height' => 'default',
                'class' => '',
                            ), $atts, 'course_featured_video'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $video_src = get_post_meta($course_id, 'course_video_url', true);

            $video_extension = pathinfo($video_src, PATHINFO_EXTENSION);

            $content = '';

            if ( !empty($video_extension) ) {//it's file, most likely on the server
                $attr = array(
                    'src' => $video_src,
                );

                if ( 'default' != $width ) {
                    $attr['width'] = $width;
                }

                if ( 'default' != $height ) {
                    $attr['height'] = $height;
                }

                $content .= wp_video_shortcode($attr);
            } else {

                $embed_args = array();

                if ( 'default' != $width ) {
                    $embed_args['width'] = $width;
                }

                if ( 'default' != $height ) {
                    $embed_args['height'] = $height;
                }

                $content .= wp_oembed_get($video_src, $embed_args);
            }

            ob_start();
            ?>
            <div class="course-featured-video course-featured-video-<?php echo $course_id; ?> <?php echo $class; ?>">
                <?php echo $content; ?>
            </div>
            <?php
            $content = ob_get_clean();
            // Return the html in the buffer.
            return $content;
        }

        /**
         * Shows the course join button.
         *
         * @since 1.0.0
         */
        function course_join_button( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'course_full_text' => __('Course Full', 'cp'),
                'course_expired_text' => __('Not available', 'cp'),
                'enrollment_finished_text' => __('Enrollments Finished', 'cp'),
                'enrollment_closed_text' => __('Enrollments Closed', 'cp'),
                'enroll_text' => __('Enroll now', 'cp'),
                'signup_text' => __('Signup!', 'cp'),
                'details_text' => __('Details', 'cp'),
                'prerequisite_text' => __('Pre-requisite Required', 'cp'),
                'passcode_text' => __('Passcode Required', 'cp'),
                'not_started_text' => __('Not Available', 'cp'),
                'access_text' => __('Start Learning', 'cp'),
                'class' => '',
                            ), $atts, 'course_join_button'));

            // Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            global $enrollment_process_url, $signup_url;

            $course->enroll_type = get_post_meta($course_id, 'enroll_type', true);
            $course->course_start_date = get_post_meta($course_id, 'course_start_date', true);
            $course->course_end_date = get_post_meta($course_id, 'course_end_date', true);
            $course->enrollment_start_date = get_post_meta($course_id, 'enrollment_start_date', true);
            $course->enrollment_end_date = get_post_meta($course_id, 'enrollment_end_date', true);
            $course->open_ended_course = 'off' == get_post_meta($course_id, 'open_ended_course', true) ? false : true;
            $course->open_ended_enrollment = 'off' == get_post_meta($course_id, 'open_ended_enrollment', true) ? false : true;
            $course->prerequisite = get_post_meta($course_id, 'prerequisite', true);

            $course_active = true; // NEED CHECK HERE

            $course_started = strtotime($course->course_start_date) <= time() ? true : false;
            $enrollment_started = strtotime($course->enrollment_start_date) <= time() ? true : false;
            $course_expired = strtotime($course->course_end_date) < time() ? true : false;
            $enrollment_expired = strtotime($course->enrollment_end_date) < time() ? true : false;
            $course_full = $course->is_populated();

            $button = '';
            $button_url = $enrollment_process_url;
            $is_form = false;

            // User is not logged in, so we need to see if course is ready for signup or not.
            if ( !is_user_logged_in() ) {

                if ( 'manually' != $course->enroll_type ) {
                    if ( $course_full ) {
                        // "COURSE FULL"
                        $button .= '<span class="apply-button apply-button-full ' . $class . '">' . $course_full_text . '</span>';
                        // cp_write_log( 'ONE');
                    } else {

                        // Course expired
                        if ( $course_expired && !$course->open_ended_course ) {
                            // "COURSE FINISHED"
                            $button .= '<span class="apply-button apply-button-finished ' . $class . '">' . $course_expired_text . '</span>';
                            // cp_write_log( 'TWO');
                            // Course hasn't expired, but its not yet available for enrollments (closed)
                        } elseif ( !$enrollment_started && !$course->open_ended_enrollment ) {
                            // "ENROLLMENT NOT YET AVAILABLE/CLOSED"
                            $button .= '<span class="apply-button apply-button-enrollment-closed ' . $class . '">' . $enrollment_closed_text . '</span>';
                            // cp_write_log( 'THREE');
                            // Course is available, but enrollments have expired
                        } elseif ( !$enrollment_expired && !$course->open_ended_enrollment ) {
                            // "ENROLLMENTS ARE FINISHED"
                            $button .= '<span class="apply-button apply-button-enrollment-finished ' . $class . '">' . $enrollment_finished_text . '</span>';
                            // cp_write_log( 'FOUR');	
                        } elseif ( !is_single() ) {
                            // GO TO COURSE
                            $button_url = get_permalink($course_id);
                            $button .= '<button data-link="' . $button_url . '" class="apply-button-enrolled ' . $class . '">' . $details_text . '</button>';
                            // cp_write_log( 'FIVE');
                            // Course hasn't expired and enrollments are open... Lets sign up!
                        } else {
                            // "SIGN UP NOW"
                            $button_url = $signup_url;
                            $button .= '<button data-link="' . $button_url . '?course_id=' . $course_id . '" class="apply-button ' . $class . '">' . $signup_text . '</button>';
                            // cp_write_log( 'SIX');	
                        }
                    }
                } else {
                    // nothing to do here when its a manual enrollment
                }

                // User is logged in, if its a student, lets see if they can access their course.	
            } else {

                // Assume user is a student
                $student = new Student(get_current_user_id());

                // If the student is not enrolled in the course, lets get them enrolled!
                if ( !$student->user_enrolled_in_course($course_id) ) {

                    if ( $course_full ) {
                        // "COURSE FULL"
                        $button .= '<span class="apply-button apply-button-full ' . $class . '">' . $course_full_text . '</span>';
                        // cp_write_log( 'SEVEN');			
                        // We've got room, but make sure its not expired	
                    } elseif ( $course_expired && !$course->open_ended_course ) {
                        // "COURSE FINISHED"
                        $button .= '<span class="apply-button apply-button-finished ' . $class . '">' . $course_expired_text . '</span>';
                        // cp_write_log( 'EIGHT');				
                        // Course hasn't expired, but its not yet available for enrollments (closed)
                    } elseif ( !$enrollment_started && !$course->open_ended_enrollment ) {
                        // "ENROLLMENT NOT YET AVAILABLE"
                        $button .= '<span class="apply-button apply-button-enrollment-closed ' . $class . '">' . $enrollment_closed_text . '</span>';
                        // cp_write_log( 'NINE');					
                        // Course is available, but enrollments have expired
                    } elseif ( !$enrollment_expired && !$course->open_ended_enrollment ) {
                        // "ENROLLMENTS ARE FINISHED"
                        $button .= '<span class="apply-button apply-button-enrollment-finished ' . $class . '">' . $enrollment_finished_text . '</span>';
                        // cp_write_log( 'TEN');
                        //We're not on a single page, so we're probably on a course list page. Behaviour is slightly different.
                    } elseif ( !is_single() ) {
                        // GO TO COURSE
                        $button_url = get_permalink($course_id);
                        $button .= '<button data-link="' . $button_url . '" class="apply-button-enrolled ' . $class . '">' . $details_text . '</button>';
                        // cp_write_log( 'ELEVEN');
                        // Enrollments are open, but requires a prerequisite
                    } elseif ( 'prerequisite' == $course->enroll_type ) {
                        // PREREQUISITE CODE HERE
                        $button .= '<span class="apply-button apply-button-prerequisite ' . $class . '">' . $prerequisite_text . '</span>';
                        // cp_write_log( 'TWELVE');
                        // No prerequisites, but requires a passcode
                    } elseif ( 'passcode' == $course->enroll_type ) {
                        // PASSCODE CODE
                        $button .= '<div class="passcode-box"><label>' . $passcode_text . ' <input type="password" name="passcode" /></label></div>';
                        $button .= '<input type="submit" class="apply-button ' . $class . '" value="' . $enroll_text . '" />';
                        $is_form = true;
                        // cp_write_log( 'THIRTEEN');
                        // No passcodes, so lets join.
                    } else {
                        // ENROLL
                        $button .= '<input type="submit" class="apply-button ' . $class . '" value="' . $enroll_text . '" />';
                        $is_form = true;
                        // cp_write_log( 'FOURTEEN');	
                    }

                    // Student is enrolled, but lets see if they can still access it.	
                } else {

                    // The course is finished.
                    if ( $course_expired && !$course->open_ended_course ) {
                        // "COURSE FINISHED"
                        $button .= '<span class="apply-button apply-button-finished ' . $class . '">' . $course_expired_text . '</span>';
                        // cp_write_log( 'FIFTEEN');		
                        // Course hasn't expired, but is not yet available
                    } elseif ( !$course_started && !$course->open_ended_course ) {
                        // "NOT YET AVAILABLE"
                        $button .= '<span class="apply-button apply-button-not-started ' . $class . '">' . $not_started_text . '</span>';
                        // cp_write_log( 'SIXTEEN');			
                    } elseif ( !is_single() && false === strpos($_SERVER['REQUEST_URI'], CoursePress::get_student_dashboard_slug()) ) {
                        // GO TO COURSE
                        $button_url = get_permalink($course_id);
                        $button .= '<button data-link="' . $button_url . '" class="apply-button-enrolled ' . $class . '">' . $details_text . '</button>';
                        // cp_write_log( 'SEVENTEEN');				
                        // Course is available, so lets go to class
                    } else {
                        // "GO TO CLASS"
                        $button_url = get_permalink($course_id) . 'units/';
                        $button .= '<button data-link="' . $button_url . '" class="apply-button-enrolled ' . $class . '">' . $access_text . '</button>';
                        // cp_write_log( 'EIGHTEEN');					
                    }
                }
            }

            // $button to output
            if ( $is_form ) {
                $button = '<form name="enrollment-process" method="post" action="' . $button_url . '">' . $button;
                $button .= wp_nonce_field('enrollment_process');
                $button .= '<input type="hidden" name="course_id" value="' . $course_id . '" />';
                $button .= '</form>';
            }

            return $button;
        }

        /**
         * Shows the course thumbnail.
         *
         * @since 1.0.0
         */
        function course_thumbnail( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'wrapper' => 'figure',
                'class' => '',
                            ), $atts, 'course_thumbnail'));

            // Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $thumbnail = Course::get_course_thumbnail($course_id);

            $content = '';

            if ( !empty($thumbnail) ) {
                ob_start();

                if ( !empty($wrapper) ) {
                    $content = '<' . $wrapper . ' class="course-thumbnail course-thumbnail-' . $course_id . ' ' . $class . '">';
                }
                ?>
                <img src="<?php echo $thumbnail; ?>" class="course-thumbnail-img"></img>
                <?php
                $content .= trim(ob_get_clean());

                if ( !empty($wrapper) ) {
                    $content .= '</' . $wrapper . '>';
                }
            }

            return $content;
        }

        /**
         * Shows the course structure.
         *
         * @since 1.0.0
         */
        function course_structure( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'free_text' => __('Free', 'cp'),
                'free_show' => true,
                'show_title' => 'no',
                'show_label' => 'no',
                'label_delimeter' => ': ',
                'label_tag' => 'h2',
                'show_divider' => 'yes',
                'label' => __('Course Structure', 'cp'),
                'class' => '',
                            ), $atts, 'course_structure'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            if ( $course->details->course_structure_options == 'on' ) {
                $content = '';

                $show_unit = $course->details->show_unit_boxes;
                $preview_unit = $course->details->preview_unit_boxes;

                $show_page = $course->details->show_page_boxes;
                $preview_page = $course->details->preview_page_boxes;

                $units = $course->get_units();

                $content .= '<div class="course-structure-block course-structure-block-' . $course_id . '">';

                if ( !empty($label) ) {
                    $content .= '<' . $label_tag . ' class="label">' . $label . $label_delimeter . '</' . $label_tag . '>';
                }

                $content .= 'yes' == $show_title ? '<label>' . $this->details->post_title . '</label>' : '';

                if ( $units ) {
                    ob_start();
                    ?>
                    <ul class="tree">
                        <li>
                            <ul>
                                <?php
                                $module = new Unit_Module();

                                foreach ( $units as $unit ) {
                                    $unit_class = new Unit($unit->ID);
                                    $unit_pages = $unit_class->get_number_of_unit_pages();

                                    $modules = $module->get_modules($unit->ID);

                                    if ( isset($show_unit[$unit->ID]) && $show_unit[$unit->ID] == 'on' && $unit->post_status == 'publish' ) {
                                        ?>
                                        <li>
                                            <label for="unit_<?php echo $unit->ID; ?>" class="course_structure_unit_label">
                                                <div class="tree-unit-left"><?php echo $unit->post_title; ?></div>
                                                <div class="tree-unit-right">

                                                    <?php if ( $course->details->course_structure_time_display == 'on' ) { ?>
                                                        <span><?php echo $unit_class->get_unit_time_estimation($unit->ID); ?></span>
                                                    <?php } ?>

                                                    <?php
                                                    if ( isset($preview_unit[$unit->ID]) && $preview_unit[$unit->ID] == 'on' ) {
                                                        ?>
                                                        <a href="<?php echo $unit_class->get_permalink(); ?>?try" class="preview_option"><?php echo $free_text; ?></a>
                                                    <?php } ?>
                                                </div>
                                            </label>

                                            <ul>
                                                <?php
                                                for ( $i = 1; $i <= $unit_pages; $i++ ) {
                                                    if ( isset($show_page[$unit->ID . '_' . $i]) && $show_page[$unit->ID . '_' . $i] == 'on' ) {
                                                        ?>
                                                        <li class="course_structure_page_li">
                                                            <?php
                                                            $pages_num = 1;
                                                            $page_title = $unit_class->get_unit_page_name($i);
                                                            ?>

                                                            <label for="page_<?php echo $unit->ID . '_' . $i; ?>">
                                                                <div class="tree-page-left">
                                                                    <?php echo (isset($page_title) && $page_title !== '' ? $page_title : __('Untitled Page', 'cp')); ?>
                                                                </div>
                                                                <div class="tree-page-right">

                                                                    <?php if ( $course->details->course_structure_time_display == 'on' ) { ?>
                                                                        <span><?php echo $unit_class->get_unit_page_time_estimation($unit->ID, $i); ?></span>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ( isset($preview_page[$unit->ID . '_' . $i]) && $preview_page[$unit->ID . '_' . $i] == 'on' ) {
                                                                        ?>
                                                                        <a href="<?php echo $unit_class->get_permalink(); ?>page/<?php echo $i; ?>?try" class="preview_option"><?php echo $free_text; ?></a>
                                                                    <?php } ?>

                                                                </div>
                                                            </label>

                                                            <?php
                                                            ?>
                                                        </li>
                                                        <?php
                                                    }
                                                }//page visible 
                                                ?>

                                            </ul>
                                        </li>
                                        <?php
                                    }//unit visible
                                } // foreach
                                ?>
                            </ul>
                        </li>
                    </ul>

                    <?php if ( $show_divider == 'yes' ) { ?>
                        <div class="divider"></div>
                    <?php } ?>

                    <?php
                    $content .= trim(ob_get_clean());
                } else {
                    
                }

                $content .= '</div>';

                return $content;
            }
        }

        /**
         * Shows a featured course.
         *
         * @since 1.0.0
         */
        function course_featured( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => '',
                'featured_title' => __('Featured Course', 'cp'),
                'button_title' => __('Find out more.', 'cp'),
                'media_type' => '', // video, image, thumbnail
                'media_priority' => 'video', // video, image
                'class' => '',
                            ), $atts, 'course_featured'));
            $content = '';

            if ( !empty($course_id) ) {
                $course = new Course($course_id);

                ob_start();
                ?>
                <div class="featured-course featured-course-<?php echo $course_id; ?>">
                    <h2><?php echo $featured_title; ?></h2>
                    <h3 class="featured-course-title"><?php echo $course->details->post_title; ?></h3>
                    <?php
                    echo do_shortcode('[course_media type="' . $media_type . '" priority="' . $media_priority . '" course_id="' . $course_id . '"]');
                    ?>
                    <div class="featured-course-summary">
                        <?php echo do_shortcode('[course_summary course_id="' . $course_id . '" length="30"]'); ?>
                    </div>

                    <div class="featured-course-link">
                        <button data-link="<?php echo $course->get_permalink($course_id) ?>"><?php echo $button_title; ?></button>
                    </div>
                </div>
                <?php
                $content .= trim(ob_get_clean());
            }

            return $content;
        }

        /**
         * Shows the course media (video or image).
         *
         * @since 1.0.0
         */
        function course_media( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'type' => '', // default, video, image
                'priority' => '', // gives priority to video (or image)
                'list_page' => 'no',
                'class' => '',
                            ), $atts, 'course_thumbnail'));

            if ( 'yes' != $list_page ) {
                $type = empty($type) ? get_option('details_media_type', 'default') : $type;
                $priority = empty($priority) ? get_option('details_media_priority', 'video') : $priority;
            } else {
                $type = empty($type) ? get_option('listings_media_type', 'default') : $type;
                $priority = empty($priority) ? get_option('listings_media_priority', 'image') : $priority;
            }

            $priority = 'default' != $type ? false : $priority;

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $course_video = get_post_meta($course_id, 'course_video_url', true);
            $course_image = get_post_meta($course_id, 'featured_url', true);

            $content = '';

// If type is thumbnail, return early
            if ( 'thumbnail' == $type ) {
                return do_shortcode('[course_thumbnail]');
            }

            if ( ( ( 'default' == $type && 'video' == $priority ) || 'video' == $type || ( 'default' == $type && 'image' == $priority && empty($course_image) ) ) && !empty($course_video) ) {

                ob_start();
                ?>
                <div class="video_player <?php echo 'course-featured-media course-featured-media-' . $course_id . ' ' . $class; ?>">
                    <?php
                    $video_extension = pathinfo($course_video, PATHINFO_EXTENSION);

                    if ( !empty($video_extension) ) {//it's file, most likely on the server
                        $attr = array(
                            'src' => $course_video,
                                //'width' => $data->player_width,
                                //'height' => 550//$data->player_height,
                        );
                        echo wp_video_shortcode($attr);
                    } else {
                        $embed_args = array(
                                //'width' => $data->player_width,
                                //'height' => 550
                        );

                        echo wp_oembed_get($course_video);
                    }
                    ?>
                </div>
                <?php
                $content .= trim(ob_get_clean());
            }

            if ( ( ( 'default' == $type && 'image' == $priority ) || 'image' == $type || ( 'default' == $type && 'video' == $priority && empty($course_video) ) ) && !empty($course_image) ) {
                $content .= '<div class="course-thumbnail course-featured-media course-featured-media-' . $course_id . ' ' . $class . '">';
                ob_start();
                ?>
                <img src="<?php echo $course_image; ?>" class="course-media-img"></img>
                <?php
                $content .= trim(ob_get_clean());
                $content .= '</div>';
            }

            return $content;
        }

        /**
         * Shows the course action links.
         *
         * @since 1.0.0
         */
        function course_action_links( $atts ) {
            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'class' => '',
                            ), $atts, 'course_action_links'));

// Saves some overhead by not loading the post again if we don't need to.
            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $course->course_start_date = get_post_meta($course_id, 'course_start_date', true);
            $course->course_end_date = get_post_meta($course_id, 'course_end_date', true);
            $course->open_ended_course = 'off' == get_post_meta($course_id, 'open_ended_course', true) ? false : true;

            $withdraw_link_visible = false;

            $content = '';

            $student = new Student(get_current_user_id());

            if ( $student && $student->user_enrolled_in_course($course_id) ) {
                if ( ( ( strtotime($course->course_start_date) <= time() && strtotime($course->course_end_date) >= time() ) || ( strtotime($course->course_end_date) >= time() ) ) || $course->open_ended_course == 'on' ) {
//course is currently active or is not yet active ( will be active in the future )
                    $withdraw_link_visible = true;
                }
            }

            $content = '<div class="apply-links course-action-links course-action-links-' . $course_id . ' ' . $class . '">';

            if ( $withdraw_link_visible === true ) {
                $content .= '<a href="?withdraw=' . $course_id . '" onClick="return withdraw();">' . __('Withdraw', 'cp') . '</a> | ';
            }
            $content .= '<a href="' . get_permalink($course_id) . '">' . __('Course Details', 'cp') . '</a></div>';

            return $content;
        }

        /**
         * Shows the course calendar.
         *
         * @since 1.0.0
         */
        function course_calendar( $atts ) {
            global $post;

            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : false,
                'month' => false,
                'year' => false,
                'pre' => __('« Previous', 'cp'),
                'next' => __('Next »', 'cp'),
                            ), $atts, 'course_calendar'));

            if ( empty($course_id) ) {
                if ( $post && 'course' == $post->post_type ) {
                    $course_id = $post->ID;
                } else {
                    $parent_id = do_shortcode('[get_parent_course_id]');
                    $course_id = 0 != $parent_id ? $parent_id : $course_id;
                }
            }

            $args = array();

            if ( !empty($month) && !empty($year) ) {
                $args = array( 'course_id' => $course_id, 'month' => $month, 'year' => $year );
            } else {
                $args = array( 'course_id' => $course_id );
            }


            $cal = new Course_Calendar($args);
            return $cal->create_calendar($pre, $next);
        }

        /**
         * Shows the course list.
         *
         * @since 1.0.0
         */
        function course_list( $atts ) {

            extract(shortcode_atts(array(
                'course_id' => '',
                'status' => 'publish',
                'instructor' => '', // Note, one or the other
                'student' => '', // If both student and instructor is specified only student will be used			
                'two_column' => 'yes',
                'left_class' => '',
                'right_class' => '',
                'course_class' => '',
                'title_link' => 'yes',
                'title_class' => 'course-title',
                'title_tag' => 'h3',
                'show' => 'dates,enrollment_dates,class_size,cost',
                'show_button' => 'yes',
                'show_divider' => 'yes',
                'show_media' => 'false',
                'media_type' => get_option('listings_media_type', 'image'), // default, image, video
                'media_priority' => get_option('listings_media_priority', 'image'), // image, video
                'limit' => -1,
                'order' => 'ASC',
                'class' => '',
                            ), $atts, 'course_list'));

            $status = 'published' == $status ? 'publish' : $status;

// student or instructor ids provided
            $user_provided = false;
            $user_provided = empty($student) ? empty($instructor) ? false : true  : true;

            $content = '';
            $courses = array();

            if ( !empty($instructor) ) {
                $include_ids = array();
                $instructors = explode(',', $instructor);
                if ( !empty($instructors) ) {
                    foreach ( $instructors as $ins ) {
                        $ins = ( int ) $ins;
                        if ( $ins ) {
                            $ins = new Instructor($ins);
                            $course_ids = $ins->get_assigned_courses_ids($status);
                            if ( $course_ids ) {
                                $include_ids = array_unique(array_merge($include_ids, $course_ids));
                            }
                        }
                    }
                } else {
                    $instructor = ( int ) $instructor;
                    if ( $instructor ) {
                        $instructor = new Instructor($ins);
                        $course_ids = $instructor->get_assigned_courses_ids($status);
                        if ( $course_ids ) {
                            $include_ids = array_unique(array_merge($include_ids, $course_ids));
                        }
                    }
                }
            }

            if ( !empty($student) ) {
                $include_ids = array();

                $students = explode(',', $student);
                if ( !empty($students) ) {
                    foreach ( $students as $stud ) {
                        $stud = ( int ) $stud;
                        if ( $stud ) {
                            $stud = new Student($stud);
                            $course_ids = $stud->get_assigned_courses_ids($status);
                            if ( $course_ids ) {
                                $include_ids = array_unique(array_merge($include_ids, $course_ids));
                            }
                        }
                    }
                } else {
                    $student = ( int ) $student;
                    if ( $student ) {
                        $student = new Student($student);
                        $course_ids = $student->get_assigned_courses_ids($status);
                        if ( $course_ids ) {
                            $include_ids = array_unique(array_merge($include_ids, $course_ids));
                        }
                    }
                }
            }

//cp_write_log($include_ids);

            $post_args = array(
                'order' => $order,
                'post_type' => 'course',
                'meta_key' => 'enroll_type',
                'post_status' => $status,
                'posts_per_page' => $limit
            );

            if ( !empty($include_ids) ) {
                $post_args = wp_parse_args(array( 'include' => $include_ids ), $post_args);
            }


            if ( $user_provided && !empty($include_ids) || !$user_provided ) {
                $courses = get_posts($post_args);
            }

            $content .= '<div class="course-list ' . $class . '">';

            foreach ( $courses as $course ) {
                $content .= '<div class="course-list-item ' . $course_class . '">';
                if ( 'yes' == $show_media ) {
                    $content .= do_shortcode('[course_media course_id="' . $course->ID . '" type="' . $media_type . '" priority="' . $media_priority . '"]');
                }
                $content .= do_shortcode('[course_title course_id="' . $course->ID . '" link="' . $title_link . '" class="' . $title_class . '" title_tag="' . $title_tag . '"]');

                if ( 'yes' == $two_column ) {
                    $content .= '<div class="course-list-box-left ' . $left_class . '">';
                }

// One liner...
                $content .= do_shortcode('[course show="' . $show . '" show_title="yes" course_id="' . $course->ID . '"]');

                if ( 'yes' == $two_column ) {
                    $content .= '</div>';
                    $content .= '<div class="course-list-box-right ' . $right_class . '">';
                }

                if ( 'yes' == $show_button ) {
                    $content .= do_shortcode('[course_join_button course_id="' . $course->ID . '"]');
                }

// Add action links if student
                if ( !empty($student) ) {
                    $content .= do_shortcode('[course_action_links course_id="' . $course->ID . '"]');
                }

                if ( 'yes' == $two_column ) {
                    $content .= '</div>';
                }

                if ( 'yes' == $show_divider ) {
                    $content .= '<div class="divider" ></div>';
                }
            } // foreach

            if ( (!$courses || 0 == count($courses) ) && !empty($instructor) ) {
                $content .= __('The Instructor does not have any courses assigned yet.', 'cp');
            }

            if ( (!$courses || 0 == count($courses) ) && !empty($student) ) {
                $content .= sprintf(__('You have not yet enrolled in a course. Browse courses %s', 'cp'), '<a href="' . trailingslashit(site_url() . '/' . CoursePress::instance()->get_course_slug()) . '">' . __('here', 'cp') . '</a>');
            }

            $content .= '</div>'; //course-list

            return $content;
        }

        /**
         *
         * INSTRUCTOR DETAILS SHORTCODES
         * =========================
         *
         */

        /**
         * Shows all the instructors of the given course.
         *
         * Four styles are supported:  
         *
         * * style="block" - List profile blocks including name, avatar, description (optional) and profile link. You can choose to make the entire block clickable ( link_all="yes" ) or only the profile link ( link_all="no", Default).
         * * style="list"  - Lists instructor display names (separated by list_separator).  
         * * style="link"  - Same as 'list', but returns hyperlinks to instructor profiles.  
         * * style="count" - Outputs a simple integer value with the total of instructors for the course.  
         *
         * @since 1.0.0
         */
        function course_instructors( $atts ) {
            global $wp_query;
            global $instructor_profile_slug;

            extract(shortcode_atts(array(
                'course_id' => in_the_loop() ? get_the_ID() : '',
                'course' => false,
                'label' => __('Instructor', 'cp'),
                'label_plural' => __('Instructors', 'cp'),
                'label_delimeter' => ': ',
                'label_tag' => '',
                'count' => false, // deprecated
                'list' => false, // deprecated
                'link' => false,
                'link_text' => __('View Full Profile', 'cp'),
                'show_label' => false, // yes, no
                'summary_length' => 50,
                'style' => 'block', //list, list-flat, block, count
                'list_separator' => ', ',
                'avatar_size' => 80,
                'default_avatar' => '',
                'show_divider' => 'yes',
                'link_all' => 'no',
                'class' => '',
                            ), $atts, 'course_instructors'));

// Support previous arguments
            $style = $count ? 'count' : $style;
            $style = $list ? 'list-flat' : $style;

            $show_label = 'list-flat' == $style && !$show_label ? 'yes' : $show_label;

            $course = empty($course) ? new Course($course_id) : object_decode($course, 'Course');

            $instructors = Course::get_course_instructors($course_id);
            $list = array();
            $content = '';

            if ( 0 < count($instructors) && 'yes' == $show_label ) {
                if ( !empty($label_tag) ) {
                    $content .= '<' . $label_tag . '>';
                }

                $content .= count($instructors) > 1 ? $label_plural . $label_delimeter : $label . $label_delimeter;

                if ( !empty($label_tag) ) {
                    $content .= '</' . $label_tag . '>';
                }
            }

            if ( 'count' != $style ) {
                foreach ( $instructors as $instructor ) {

                    $profile_href = trailingslashit(site_url()) . trailingslashit($instructor_profile_slug) . trailingslashit($instructor->user_login);

                    switch ( $style ) {

                        case 'block':
                            ob_start();
                            ?>
                            <div class="instructor-profile <?php echo $class; ?>">
                                <?php if ( 'yes' == $link_all ) { ?>
                                    <a href="<?php echo $profile_href ?>">
                                    <?php } ?>
                                    <div class="profile-name"><?php echo $instructor->display_name; ?></div>
                                    <div class="profile-avatar">
                                        <?php echo get_avatar($instructor->ID, $avatar_size, $default_avatar, $instructor->display_name); ?>
                                    </div>
                                    <div class="profile-description"><?php echo $this->author_description_excerpt($instructor->ID, $summary_length); ?></div>
                                    <div class="profile-link">
                                        <?php if ( 'no' == $link_all ) { ?>
                                            <a href="<?php echo $profile_href ?>">
                                            <?php } ?>
                                            <?php echo $link_text; ?>
                                            <?php if ( 'no' == $link_all ) { ?>
                                            </a>
                                        <?php } ?>								
                                    </div>
                                    <?php if ( 'yes' == $link_all ) { ?>
                                    </a>
                                <?php } ?>
                            </div>	
                            <?php
                            $content .= ob_get_clean();
                            break;

                        case 'link':
                        case 'list':
                        case 'list-flat':
                            $list[] = ( $link ? '<a href="' . $profile_href . '">' . $instructor->display_name . '</a>' : $instructor->display_name );

                            break;
                    }
                }
            }

            switch ( $style ) {

                case 'block':
                    $content = '<div class="instructor-block ' . $class . '">' . $content . '</div>';
                    if ( $show_divider == 'yes' && (0 < count($instructors)) ) {
                        $content .= '<div class="divider"></div>';
                    }
                    break;

                case 'list-flat':
// $content = '';
// if( 0 < count( $instructors ) && ! empty( $label ) ) {
// 	$content = count( $instructors ) > 1 ? $label_plural . $label_delimeter : $label . $label_delimeter;
// }
                    $content .= implode($list_separator, $list);
                    $content = '<div class="instructor-list instructor-list-flat ' . $class . '">' . $content . '</div>';
                    break;

                case 'list':
// $content = '';
// if( 0 < count( $instructors ) && ! empty( $label ) ) {
// 	$content = count( $instructors ) > 1 ? $label_plural . $label_delimeter : $label . $label_delimeter;
// }

                    $content .= '<ul>';
                    foreach ( $list as $instructor ) {
                        $content .= '<li>' . $instructor . '</li>';
                    }
                    $content .= '</ul>';
                    $content = '<div class="instructor-list ' . $class . '">' . $content . '</div>';
                    break;

                case 'count':
                    $content = count($instructors);
                    break;
            }

            return $content;
        }

        function course_instructor_avatar( $atts ) {
            global $wp_query;

            extract(shortcode_atts(array( 'instructor_id' => 0, 'thumb_size' => 80, 'class' => 'small-circle-profile-image' ), $atts));

            $doc = new DOMDocument();
            $doc->loadHTML(get_avatar($instructor_id, $thumb_size));
            $imageTags = $doc->getElementsByTagName('img');

            $content = '';

            foreach ( $imageTags as $tag ) {
                $avatar_url = $tag->getAttribute('src');
            }
            ?>
            <?php
            $content .= '<div class="instructor-avatar">';
            $content .= '<div class="' . $class . '" style="background: url( ' . $avatar_url . ' );"></div>';
            $content .= '</div>';

            return $content;
        }

        function instructor_profile_url( $atts ) {
            global $instructor_profile_slug;

            extract(shortcode_atts(array(
                'instructor_id' => 0 ), $atts));

            $instructor = get_userdata($instructor_id);

            if ( $instructor_id ) {
                return trailingslashit(site_url()) . trailingslashit($instructor_profile_slug) . trailingslashit($instructor->user_login);
            }
        }

        /**
         *
         * UNIT DETAILS SHORTCODES
         * =========================
         *
         */
        function course_unit_archive_submenu( $atts ) {
            global $coursepress;

            extract(shortcode_atts(array(
                'course_id' => ''
                            ), $atts));

            if ( $course_id == '' ) {
                $course_id = do_shortcode('[get_parent_course_id]');
            }

            if ( isset($coursepress->units_archive_subpage) ) {
                $subpage = $coursepress->units_archive_subpage;
            } else {
                $subpage = '';
            }
            ?>
            <div class="submenu-main-container">
                <ul id="submenu-main" class="submenu nav-submenu">
                    <li class="submenu-item submenu-units <?php echo( isset($subpage) && $subpage == 'units' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink($course_id) . $coursepress->get_units_slug(); ?>/"><?php _e('Units', 'coursepress'); ?></a></li>
                    <li class="submenu-item submenu-notifications <?php echo( isset($subpage) && $subpage == 'notifications' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink($course_id) . $coursepress->get_notifications_slug(); ?>/"><?php _e('Notifications', 'coursepress'); ?></a></li>
                    <?php
                    $course_obj = new Course($course_id);
                    $course = $course_obj->get_course();
                    if ( $course->allow_course_discussion == 'on' ) {
                        ?>
                        <li class="submenu-item submenu-discussions <?php echo( isset($subpage) && $subpage == 'discussions' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink($course_id) . $coursepress->get_discussion_slug(); ?>/"><?php _e('Discussions', 'coursepress'); ?></a></li>
                        <?php
                    }
                    /* if ( $course->allow_course_grades_page == 'on' ) {
                      ?>
                      <li class="submenu-item submenu-grades <?php echo( isset( $subpage ) && $subpage == 'grades' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_grades_slug(); ?>/"><?php _e( 'Grades', 'coursepress' ); ?></a></li>
                      <?php
                      } */
                    if ( $course->allow_workbook_page == 'on' ) {
                        ?>
                        <li class="submenu-item submenu-workbook <?php echo( isset($subpage) && $subpage == 'workbook' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink($course_id) . $coursepress->get_workbook_slug(); ?>/"><?php _e('Workbook', 'coursepress'); ?></a></li>
                    <?php } ?>
                    <li class="submenu-item submenu-info"><a href="<?php echo get_permalink($course_id); ?>"><?php _e('Course Details', 'coursepress'); ?></a></li>
                </ul><!--submenu-main-->
            </div><!--submenu-main-container-->
            <?php
        }

        function courses_urls( $atts ) {
            global $enrollment_process_url, $signup_url;

            extract(shortcode_atts(array(
                'url' => ''
                            ), $atts));

            if ( $url == 'enrollment-process' ) {
                return $enrollment_process_url;
            }

            if ( $url == 'signup' ) {
                return $signup_url;
            }
        }

        function units_dropdown( $atts ) {
            extract(shortcode_atts(array( 'course_id' => ( isset($wp_query->post->ID) ? $wp_query->post->ID : 0 ), 'include_general' => false, 'general_title' => '' ), $atts));
            $course_obj = new Course($course_id);
            $units = $course_obj->get_units();

            $dropdown = '<div class="units_dropdown_holder"><select name="units_dropdown" class="units_dropdown">';
            if ( $include_general ) {
                if ( $general_title == '' ) {
                    $general_title = __('-- General --', 'cp');
                }
                $dropdown .= '<option value="">' . $general_title . '</option>';
            }
            foreach ( $units as $unit ) {
                $dropdown .= '<option value="' . $unit->ID . '">' . $unit->post_title . '</option>';
            }
            $dropdown .= '</select></div>';

            return $dropdown;
        }

        function course_details( $atts ) {
            global $wp_query, $signup_url;

            $student = new Student(get_current_user_id());

            extract(shortcode_atts(array(
                'course_id' => ( isset($wp_query->post->ID) ? $wp_query->post->ID : 0 ),
                'field' => 'course_start_date'
                            ), $atts));

            $course_obj = new Course($course_id);

            if ( $course_obj->is_open_ended() ) {
                $open_ended = true;
            } else {
                $open_ended = false;
            }

            $course = $course_obj->get_course();

            if ( $field == 'action_links' ) {

                $withdraw_link_visible = false;

                if ( $student->user_enrolled_in_course($course_id) ) {
                    if ( ( ( strtotime($course->course_start_date) <= time() && strtotime($course->course_end_date) >= time() ) || ( strtotime($course->course_end_date) >= time() ) ) || $course->open_ended_course == 'on' ) {//course is currently active or is not yet active ( will be active in the future )
                        $withdraw_link_visible = true;
                    }
                }

                $course->action_links = '<div class="apply-links">';

                if ( $withdraw_link_visible === true ) {
                    $course->action_links .= '<a href="?withdraw=' . $course->ID . '" onClick="return withdraw();">' . __('Withdraw', 'cp') . '</a> | ';
                }
                $course->action_links .= '<a href="' . get_permalink($course->ID) . '">' . __('Course Details', 'cp') . '</a></div>';
            }

            if ( $field == 'class_size' ) {
                if ( $course->class_size == '0' || $course->class_size == '' ) {
                    $course->class_size = __('Infinite', 'cp');
                } else {
                    $count_left = $course->class_size - $course_obj->get_number_of_students();
                    $course->class_size = $course->class_size . ' ' . sprintf(__('( %d left )', 'cp'), $count_left);
                }
            }

            $passcode_box_visible = false;

            if ( !isset($course->enroll_type) ) {
                $course->enroll_type = 'anyone';
            } else {
                if ( $course->enroll_type == 'passcode' ) {
                    $course->enroll_type = __('Anyone with a Passcode', 'cp');
                    $passcode_box_visible = true;
                }

                if ( $course->enroll_type == 'prerequisite' ) {
                    $course->init_enroll_type = 'prerequisite';
                    $course->enroll_type = sprintf(__('Anyone who attanded to the %1s', 'cp'), '<a href="' . get_permalink($course->prerequisite) . '">' . __('prerequisite course', 'cp') . '</a>'); //__( 'Anyone who attended to the ', 'cp' );
                }
            }

            if ( $field == 'enroll_type' ) {

                if ( $course->enroll_type == 'anyone' ) {
                    $course->enroll_type = __('Anyone', 'cp');
                }


                if ( $course->enroll_type == 'manually' ) {
                    $course->enroll_type = __('Public enrollments are disabled', 'cp');
                }
            }

            if ( $field == 'course_start_date' or $field == 'course_end_date' or $field == 'enrollment_start_date' or $field == 'enrollment_end_date' ) {
                $date_format = get_option('date_format');
                if ( $course->open_ended_course == 'on' ) {
                    $course->$field = __('Open-ended', 'cp');
                } else {
                    if ( $course->$field == '' ) {
                        $course->$field = __('N/A', 'cp');
                    } else {
                        $course->$field = sp2nbsp(date($date_format, strtotime($course->$field)));
                    }
                }
            }

            if ( $field == 'price' ) {
                global $coursepress;

                $is_paid = get_post_meta($course_id, 'paid_course', true) == 'on' ? true : false;

                if ( $is_paid && isset($course->marketpress_product) && $course->marketpress_product != '' && ($coursepress->marketpress_active) ) {
                    echo do_shortcode('[mp_product_price product_id="' . $course->marketpress_product . '" label=""]');
                } else {
                    $course->price = __('FREE', 'cp');
                }
            }

            if ( $field == 'button' ) {

                $course->button = '<form name="enrollment-process" method="post" action="' . do_shortcode("[courses_urls url='enrollment-process']") . '">';

                if ( is_user_logged_in() ) {

                    if ( !$student->user_enrolled_in_course($course_id) ) {
                        if ( !$course_obj->is_populated() ) {
                            if ( $course->enroll_type != 'manually' ) {
                                if ( strtotime($course->course_end_date) <= time() && $course->open_ended_course == 'off' ) {//Course is no longer active
                                    $course->button .= '<span class="apply-button-finished">' . __('Finished', 'cp') . '</span>';
                                } else {
                                    if ( ( $course->enrollment_start_date !== '' && $course->enrollment_end_date !== '' && strtotime($course->enrollment_start_date) <= time() && strtotime($course->enrollment_end_date) >= time() ) || $course->open_ended_course == 'on' ) {
                                        if ( ( $course->init_enroll_type == 'prerequisite' && $student->user_enrolled_in_course($course->prerequisite) ) || $course->init_enroll_type !== 'prerequisite' ) {
                                            $course->button .= '<input type="submit" class="apply-button" value="' . __('Enroll Now', 'cp') . '" />';
                                            $course->button .= '<div class="passcode-box">' . do_shortcode('[course_details field="passcode_input"]') . '</div>';
                                        } else {
                                            $course->button .= '<span class="apply-button-finished">' . __('Prerequisite Required', 'cp') . '</span>';
                                        }
                                    } else {
                                        if ( strtotime($course->enrollment_end_date) <= time() ) {
                                            $course->button .= '<span class="apply-button-finished">' . __('Not available', 'cp') . '</span>';
                                        } else {
                                            $course->button .= '<span class="apply-button-finished">' . __('Not available', 'cp') . '</span>';
                                        }
                                    }
                                }
                            } else {
//don't show any button because public enrollments are disabled with manuall enroll type
                            }
                        } else {
                            $course->button .= '<span class="apply-button-finished">' . __('Populated', 'cp') . '</span>';
                        }
                    } else {
                        if ( ( $course->course_start_date !== '' && $course->course_end_date !== '' ) || $course->open_ended_course == 'on' ) {//Course is currently active
                            if ( ( strtotime($course->course_start_date) <= time() && strtotime($course->course_end_date) >= time() ) || $course->open_ended_course == 'on' ) {//Course is currently active
                                $course->button .= '<a href="' . get_permalink($course->ID) . 'units/" class="apply-button-enrolled">' . __('Go to Class', 'cp') . '</a>';
//$course->button .= '<input type="button" data-url="' . get_permalink( $course->ID ) . 'units/" class="apply-button-enrolled">' . __( 'Go to Class', 'cp' ) . '</a>';
                            } else {

                                if ( strtotime($course->course_start_date) >= time() ) {//Waiting for a course to start
                                    $course->button .= '<span class="apply-button-pending">' . __('You are enrolled', 'cp') . '</span>';
                                }
                                if ( strtotime($course->course_end_date) <= time() ) {//Course is no longer active
                                    $course->button .= '<span class="apply-button-finished">' . __('Finished', 'cp') . '</span>';
                                }
                            }
                        } else {//Course is inactive or pending
                            $course->button .= '<span class="apply-button-finished">' . __('Not available', 'cp') . '</span>';
                        }
                    }
                } else {

                    if ( $course->enroll_type != 'manually' ) {
                        if ( !$course_obj->is_populated() ) {
                            if ( ( strtotime($course->course_end_date) <= time() ) && $course->open_ended_course == 'off' ) {//Course is no longer active
                                $course->button .= '<span class="apply-button-finished">' . __('Finished', 'cp') . '</span>';
                            } else if ( ( $course->course_start_date == '' || $course->course_end_date == '' ) && $course->open_ended_course == 'off' ) {
                                $course->button .= '<span class="apply-button-finished">' . __('Not available', 'cp') . '</span>';
                            } else {


                                if ( ( strtotime($course->enrollment_end_date) <= time() ) && $course->open_ended_course == 'off' ) {
                                    $course->button .= '<span class="apply-button-finished">' . __('Not available', 'cp') . '</span>';
                                } else {
                                    $course->button .= '<a href="' . $signup_url . '?course_id=' . $course->ID . '" class="apply-button">' . __('Signup', 'cp') . '</a>';
                                }
                            }
                        } else {
                            $course->button .= '<span class="apply-button-finished">' . __('Populated', 'cp') . '</span>';
                        }
                    }
                }
                $course->button .= '<div class="clearfix"></div>';
                $course->button .= wp_nonce_field('enrollment_process');
                $course->button .= '<input type="hidden" name="course_id" value="' . $course_id . '" />';
                $course->button .= '</form>';
            }

            if ( $field == 'passcode_input' ) {
                if ( $passcode_box_visible ) {
                    $course->passcode_input = '<label>' . __("Passcode: ", "cp") . '<input type="password" name="passcode" /></label>';
                }
            }

            if ( !isset($course->$field) ) {
                $course->$field = '';
            }

            return $course->$field;
        }

        function get_parent_course_id( $atts ) {
            global $wp;

            if ( array_key_exists('coursename', $wp->query_vars) ) {
                $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
            } else {
                $course_id = 0;
            }
            return $course_id;
        }

        function courses_student_dashboard( $atts ) {
            global $plugin_dir;
            load_template($plugin_dir . 'includes/templates/student-dashboard.php', false);
        }

        function courses_student_settings( $atts ) {
            global $plugin_dir;
            load_template($plugin_dir . 'includes/templates/student-settings.php', false);
        }

        function course_unit_single( $atts ) {
            global $wp;

            extract(shortcode_atts(array( 'unit_id' => 0 ), $atts));

            if ( empty($unit_id) ) {
                if ( array_key_exists('unitname', $wp->query_vars) ) {
                    $unit = new Unit();
                    $unit_id = $unit->get_unit_id_by_name($wp->query_vars['unitname']);
                } else {
                    $unit_id = 0;
                }
            }

            $args = array(
                'post_type' => 'unit',
                'p' => $unit_id
            );

            cp_suppress_errors();
            query_posts($args);
//cp_show_errors();
        }

        function course_units_loop( $atts ) {
            global $wp;

            extract(shortcode_atts(array( 'course_id' => 0 ), $atts));

            if ( empty($course_id) ) {
                if ( array_key_exists('coursename', $wp->query_vars) ) {
                    $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
                } else {
                    $course_id = 0;
                }
            }

            $current_date = date('Y-m-d', current_time('timestamp', 0));

            $args = array(
                'order' => 'ASC',
                'post_type' => 'unit',
                'post_status' => 'publish',
                'meta_key' => 'unit_order',
                'orderby' => 'meta_value_num',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'course_id',
                        'value' => $course_id
                    ),
                )
            );

            query_posts($args);
        }

        function course_notifications_loop( $atts ) {
            global $wp;

            extract(shortcode_atts(array( 'course_id' => 0 ), $atts));

            if ( empty($course_id) ) {
                if ( array_key_exists('coursename', $wp->query_vars) ) {
                    $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
                } else {
                    $course_id = 0;
                }
            }

            $args = array(
                'category' => '',
                'order' => 'ASC',
                'post_type' => 'notifications',
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'course_id',
                        'value' => $course_id
                    ),
                    array(
                        'key' => 'course_id',
                        'value' => ''
                    ),
                )
            );

            query_posts($args);
        }

        function course_discussion_loop( $atts ) {
            global $wp;

            extract(shortcode_atts(array( 'course_id' => 0 ), $atts));

            if ( empty($course_id) ) {
                if ( array_key_exists('coursename', $wp->query_vars) ) {
                    $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
                } else {
                    $course_id = 0;
                }
            }

            $args = array(
                'order' => 'DESC',
                'post_type' => 'discussions',
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'posts_per_page' => '-1',
                'meta_key' => 'course_id',
                'meta_value' => $course_id
            );

            query_posts($args);
        }

        function course_units( $atts ) {
            global $wp, $coursepress;

            $content = '';

            extract(shortcode_atts(array( 'course_id' => $course_id ), $atts));

            if ( empty($course_id) ) {
                if ( array_key_exists('coursename', $wp->query_vars) ) {
                    $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
                } else {
                    $course_id = 0;
                }
            }

            $course = new Course($course_id);
            $units = $course->get_units($course_id, 'publish');

            $student = new Student(get_current_user_id());
//redirect to the parent course page if not enrolled
            if ( !current_user_can('manage_options') ) {//If current user is not admin, check if he can access to the units
                if ( $course->details->post_author != get_current_user_id() ) {//check if user is an author of a course ( probably instructor )
                    if ( !current_user_can('coursepress_view_all_units_cap') ) {//check if the instructor, even if it's not the author of the course, maybe has a capability given by the admin
                        if ( !$student->has_access_to_course($course_id) ) {//if it's not an instructor who made the course, check if he is enrolled to course
// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
//ob_start();
                            wp_redirect(get_permalink($course_id)); //if not, redirect him to the course page so he may enroll it if the enrollment is available
                            exit;
                        }
                    }
                }
            }


            $content .= '<ol>';
            $last_unit_url = '';

            foreach ( $units as $unit ) {
                $unit_details = new Unit($unit->ID);
                $content .= '<li><a href="' . $unit_details->get_permalink($course_id) . '">' . $unit->post_title . '</a></li>';
                $last_unit_url = $unit_details->get_permalink($course_id);
            }

            $content .= '</ol>';

            if ( count($units) >= 1 ) {
                $content .= do_shortcode('[course_discussion]');
            }

            if ( count($units) == 0 ) {
                $content = __('0 course units prepared yet. Please check back later.', 'cp');
            }

            if ( count($units) == 1 ) {
//ob_start();
// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
                wp_redirect($last_unit_url);
                exit;
            }
            return $content;
        }

        function course_unit_details( $atts ) {
            global $post_id, $wp, $coursepress;

            extract(shortcode_atts(array(
                'unit_id' => 0,
                'field' => 'post_title',
                'format' => false,
                'additional' => '2',
                'style' => 'flat',
                'tooltip_alt' => __('Percent of the unit completion', 'coursepress'),
                'knob_fg_color' => '#24bde6',
                'knob_bg_color' => '#e0e6eb',
                'knob_data_thickness' => '.35',
                'knob_data_width' => '70',
                'knob_data_height' => '70',
                'student_id' => get_current_user_ID(),
                            ), $atts));

            $format = ( bool ) $format;

            if ( $unit_id == 0 ) {
                $unit_id = get_the_ID();
            }

            $unit = new Unit($unit_id);

            $student = new Student(get_current_user_id());


            if ( $field == 'is_unit_available' ) {
                $unit->details->$field = $unit->is_unit_available();
            }

            if ( $field == 'unit_page_title' ) {
                $paged = isset($wp->query_vars['paged']) ? absint($wp->query_vars['paged']) : 1;
                $unit->details->$field = $unit->get_unit_page_name($paged);
            }

            /* ------------ */
            $unit_module = new Unit_Module();

            $front_save_count = 0;

            $modules = $unit_module->get_modules($unit_id);
            $mandatory_answers = 0;
            $mandatory = 'no';

            foreach ( $modules as $mod ) {

                $mandatory = get_post_meta($mod->ID, 'mandatory_answer', true);

                if ( $mandatory == 'yes' ) {
                    $mandatory_answers++;
                }

                $class_name = $mod->module_type;

                if ( class_exists($class_name) ) {
                    $module = new $class_name();
                    if ( $module->front_save ) {
                        $front_save_count++;
                    }
                }
            }

            $input_modules_count = $front_save_count;
            /* ------------ */
//$input_modules_count = do_shortcode( '[course_unit_details field="input_modules_count" unit_id="' . $unit_id . '"]' );
            $unit_module = new Unit_Module();
            $responses_count = 0;

            $modules = $unit_module->get_modules($unit_id);
            foreach ( $modules as $module ) {
                $unit_module = new Unit_Module();
                if ( $unit_module->did_student_responed($module->ID, $student_id) ) {
                    $responses_count++;
                }
            }
            $student_modules_responses_count = $responses_count;

//$student_modules_responses_count = do_shortcode( '[course_unit_details field="student_module_responses" unit_id="' . $unit_id . '"]' );

            if ( $student_modules_responses_count > 0 ) {
                $percent_value = $mandatory_answers > 0 ? ( round(( 100 / $mandatory_answers ) * $student_modules_responses_count, 0) ) : 0;
                $percent_value = ( $percent_value > 100 ? 100 : $percent_value ); //in case that student gave answers on all mandatory plus optional questions
            } else {
                $percent_value = 0;
            }

            if ( $input_modules_count == 0 ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $assessable_answers = 0;
                $responses = 0;
                $graded = 0;
//$input_modules_count = do_shortcode( '[course_unit_details field="input_modules_count" unit_id="' . get_the_ID() . '"]' );
                $modules = $unit_module->get_modules($unit_id);


                if ( $input_modules_count > 0 ) {
                    foreach ( $modules as $mod ) {

                        $class_name = $mod->module_type;
                        $assessable = get_post_meta($mod->ID, 'gradable_answer', true);

                        if ( class_exists($class_name) ) {
                            $module = new $class_name();
                            if ( $module->front_save ) {

                                if ( $assessable == 'yes' ) {
                                    $assessable_answers++;
                                }

                                $front_save_count++;
                                $response = $module->get_response($student_id, $mod->ID);

                                if ( isset($response->ID) ) {
                                    $grade_data = $unit_module->get_response_grade($response->ID);
                                    $grade = $grade + $grade_data['grade'];

                                    if ( get_post_meta($response->ID, 'response_grade') ) {
                                        $graded++;
                                    }

                                    $responses++;
                                }
                            } else {
//read only module
                            }
                        }
                    }
                    $percent_value = ( $format == true ? ( $responses == $graded && $responses == $front_save_count ? '<span class="grade-active">' : '<span class="grade-inactive">' ) . ( $grade > 0 ? round(( $grade / $assessable_answers), 0) : 0 ) . '</span>' : ( $grade > 0 ? round(( $grade / $assessable_answers), 0) : 0 ) );
                } else {
                    $student = new Student($student_id);
                    if ( $student->is_unit_visited($unit_id, $student_id) ) {
                        $grade = 100;
                        $percent_value = ( $format == true ? '<span class="grade-active">' . $grade . '</span>' : $grade );
                    } else {
                        $grade = 0;
                        $percent_value = ( $format == true ? '<span class="grade-inactive">' . $grade . '</span>' : $grade );
                    }
                }

//$percent_value = do_shortcode( '[course_unit_details field="student_unit_grade" unit_id="' . get_the_ID() . '"]' );
            }

//redirect to the parent course page if not enrolled
            if ( !current_user_can('manage_options') ) {
                if ( !$coursepress->check_access($unit->course_id, $unit_id) ) {
// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
//ob_start();
                    wp_redirect(get_permalink($unit->course_id));
                    exit;
                }
            }

            if ( $field == 'percent' ) {
                $assessable_input_modules_count = do_shortcode('[course_unit_details field="assessable_input_modules_count"]');
                if ( $assessable_input_modules_count > 0 ) {
                    if ( $style == 'flat' ) {
                        $unit->details->$field = '<span class="percentage">' . ($format == true ? $percent_value . '%' : $percent_value) . '</span>';
                    } else {
                        $unit->details->$field = '<a class="tooltip" alt="' . $tooltip_alt . '"><input class="knob" data-fgColor="' . $knob_fg_color . '" data-bgColor="' . $knob_bg_color . '" data-thickness="' . $knob_data_thickness . '" data-width="' . $knob_data_width . '" data-height="' . $knob_data_height . '" data-readOnly=true value="' . $percent_value . '"></a>';
                    }
                } else {
                    $unit->details->$field = '';
                }
            }

            if ( $field == 'permalink' ) {
                $unit->details->$field = $unit->get_permalink($unit->course_id);
            }

            if ( $field == 'input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;

                $modules = $unit_module->get_modules($unit_id);

                foreach ( $modules as $mod ) {

                    $class_name = $mod->module_type;

                    if ( class_exists($class_name) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            $front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $front_save_count;
            }

            if ( $field == 'mandatory_input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;
                $mandatory_answers = 0;

                $modules = $unit_module->get_modules($unit_id);

                foreach ( $modules as $mod ) {
                    $mandatory_answer = get_post_meta($mod->ID, 'mandatory_answer', true);

                    $class_name = $mod->module_type;

                    if ( class_exists($class_name) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            if ( $mandatory_answer == 'yes' ) {
                                $mandatory_answers++;
                            }
//$front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $mandatory_answers;
            }

            if ( $field == 'assessable_input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;
                $assessable_answers = 0;

                $modules = $unit_module->get_modules($unit_id);

                foreach ( $modules as $mod ) {
                    $assessable = get_post_meta($mod->ID, 'gradable_answer', true);

                    $class_name = $mod->module_type;

                    if ( class_exists($class_name) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            if ( $assessable == 'yes' ) {
                                $assessable_answers++;
                            }
//$front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $assessable_answers;
            }

            if ( $field == 'student_module_responses' ) {
                $unit_module = new Unit_Module();
                $responses_count = 0;
                $mandatory_answers = 0;
                $modules = $unit_module->get_modules($unit_id);
                foreach ( $modules as $module ) {

                    $mandatory = get_post_meta($module->ID, 'mandatory_answer', true);

                    if ( $mandatory == 'yes' ) {
                        $mandatory_answers++;
                    }

                    $unit_module = new Unit_Module();
                    if ( $unit_module->did_student_responed($module->ID, $student_id) ) {
                        $responses_count++;
                    }
                }

                if ( $additional == 'mandatory' ) {
                    if ( $responses_count > $mandatory_answers ) {
                        $unit->details->$field = $mandatory_answers;
                    } else {
                        $unit->details->$field = $responses_count;
                    }
//so we won't have 7 of 6 mandatory answered but mandatory number as a max number
                } else {
                    $unit->details->$field = $responses_count;
                }
            }

            if ( $field == 'student_unit_grade' ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $responses = 0;
                $graded = 0;
                $input_modules_count = do_shortcode('[course_unit_details field="input_modules_count" unit_id="' . get_the_ID() . '"]');
                $modules = $unit_module->get_modules($unit_id);
                $mandatory_answers = 0;
                $assessable_answers = 0;

                if ( $input_modules_count > 0 ) {
                    foreach ( $modules as $mod ) {

                        $class_name = $mod->module_type;

                        if ( class_exists($class_name) ) {
                            $module = new $class_name();
                            if ( $module->front_save ) {
                                $front_save_count++;
                                $response = $module->get_response($student_id, $mod->ID);
                                $assessable = get_post_meta($mod->ID, 'gradable_answer', true);
                                $mandatory = get_post_meta($mod->ID, 'mandatory_answer', true);


                                if ( $assessable == 'yes' ) {
                                    $assessable_answers++;
                                }

                                if ( isset($response->ID) ) {

                                    if ( $assessable == 'yes' ) {

                                        $grade_data = $unit_module->get_response_grade($response->ID);
                                        $grade = $grade + $grade_data['grade'];

                                        if ( get_post_meta($response->ID, 'response_grade') ) {
                                            $graded++;
                                        }

                                        $responses++;
                                    }
                                }
                            } else {
//read only module
                            }
                        }
                    }

                    $unit->details->$field = ( $format == true ? ( $responses == $graded && $responses == $front_save_count ? '<span class="grade-active">' : '<span class="grade-inactive">' ) . ( $grade > 0 ? round(( $grade / $assessable_answers), 0) : 0 ) . '%</span>' : ( $grade > 0 ? round(( $grade / $assessable_answers), 0) : 0 ) );
                } else {
                    $student = new Student($student_id);
                    if ( $student->is_unit_visited($unit_id, $student_id) ) {
                        $grade = 100;
                        $unit->details->$field = ( $format == true ? '<span class="grade-active">' . $grade . '%</span>' : $grade );
                    } else {
                        $grade = 0;
                        $unit->details->$field = ( $format == true ? '<span class="grade-inactive">' . $grade . '%</span>' : $grade );
                    }
                }
            }

            if ( $field == 'student_unit_modules_graded' ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $responses = 0;
                $graded = 0;

                $modules = $unit_module->get_modules($unit_id);

                foreach ( $modules as $mod ) {

                    $class_name = $mod->module_type;

                    if ( class_exists($class_name) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            $front_save_count++;
                            $response = $module->get_response($student_id, $mod->ID);

                            if ( isset($response->ID) ) {
                                $grade_data = $unit_module->get_response_grade($response->ID);
                                $grade = $grade + $grade_data['grade'];

                                if ( get_post_meta($response->ID, 'response_grade') ) {
                                    $graded++;
                                }

                                $responses++;
                            }
                        } else {
//read only module
                        }
                    }
                }

                $unit->details->$field = $graded;
            }

            return $unit->details->$field;
        }

        function course_breadcrumbs( $atts ) {
            global $course_slug, $units_slug, $units_breadcrumbs, $wp;

            extract(shortcode_atts(array(
                'type' => 'unit_archive',
                'course_id' => 0,
                'position' => 'shortcode'
                            ), $atts));

            if ( empty($course_id) ) {
                if ( array_key_exists('coursename', $wp->query_vars) ) {
                    $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
                } else {
                    $course_id = 0;
                }
            }

            $course = new Course($course_id);

            if ( $type == 'unit_archive' ) {
                $units_breadcrumbs = '<div class="units-breadcrumbs"><a href="' . trailingslashit(get_option('home')) . $course_slug . '/">' . __('Courses', 'cp') . '</a> » <a href="' . $course->get_permalink() . '">' . $course->details->post_title . '</a></div>';
            }

            if ( $type == 'unit_single' ) {
                $units_breadcrumbs = '<div class="units-breadcrumbs"><a href="' . trailingslashit(get_option('home')) . $course_slug . '/">' . __('Courses', 'cp') . '</a> » <a href="' . $course->get_permalink() . '">' . $course->details->post_title . '</a> » <a href="' . $course->get_permalink() . $units_slug . '/">' . __('Units', 'cp') . '</a></div>';
            }

            if ( $position == 'shortcode' ) {
                return $units_breadcrumbs;
            }
        }

        function course_discussion( $atts ) {
            global $wp;

            if ( array_key_exists('coursename', $wp->query_vars) ) {
                $course_id = Course::get_course_id_by_name($wp->query_vars['coursename']);
            } else {
                $course_id = 0;
            }

            $course = new Course($course_id);

            if ( $course->details->allow_course_discussion == 'on' ) {

                $comments_args = array(
// change the title of send button 
                    'label_submit' => __('Send', 'cp'),
                    // change the title of the reply section
                    'title_reply' => __('Write a Reply or Comment', 'cp'),
                    // remove "Text or HTML to be displayed after the set of comment fields"
                    'comment_notes_after' => '',
                    // redefine your own textarea ( the comment body )
                    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun') . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
                );

                $defaults = array(
                    'author_email' => '',
                    'ID' => '',
                    'karma' => '',
                    'number' => '',
                    'offset' => '',
                    'orderby' => '',
                    'order' => 'DESC',
                    'parent' => '',
                    'post_id' => $course_id,
                    'post_author' => '',
                    'post_name' => '',
                    'post_parent' => '',
                    'post_status' => '',
                    'post_type' => '',
                    'status' => '',
                    'type' => '',
                    'user_id' => '',
                    'search' => '',
                    'count' => false,
                    'meta_key' => '',
                    'meta_value' => '',
                    'meta_query' => '',
                );

                $wp_list_comments_args = array(
                    'walker' => null,
                    'max_depth' => '',
                    'style' => 'ul',
                    'callback' => null,
                    'end-callback' => null,
                    'type' => 'all',
                    'reply_text' => __('Reply', 'cp'),
                    'page' => '',
                    'per_page' => '',
                    'avatar_size' => 32,
                    'reverse_top_level' => null,
                    'reverse_children' => '',
                    'format' => 'xhtml', //or html5 @since 3.6
                    'short_ping' => false // @since 3.6
                );

                comment_form($comments_args = array(), $course_id);
                wp_list_comments($wp_list_comments_args, get_comments($defaults));
//comments_template()
            }
        }

        function unit_discussion( $atts ) {
            global $wp;
            if ( array_key_exists('unitname', $wp->query_vars) ) {
                $unit = new Unit();
                $unit_id = $unit->get_unit_id_by_name($wp->query_vars['unitname']);
            } else {
                $unit_id = 0;
            }

            $comments_args = array(
// change the title of send button 
                'label_submit' => 'Send',
                // change the title of the reply secpertion
                'title_reply' => 'Write a Reply or Comment',
                // remove "Text or HTML to be displayed after the set of comment fields"
                'comment_notes_after' => '',
                // redefine your own textarea ( the comment body )
                'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun') . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
            );

            comment_form($comments_args, $unit_id);
        }

        function student_registration_form() {
            global $plugin_dir;
            load_template($plugin_dir . 'includes/templates/student-signup.php', true);
        }

        function author_description_excerpt( $user_id = false, $length = 100 ) {

            $excerpt = get_the_author_meta('description', $user_id);

            $excerpt = strip_shortcodes($excerpt);
            $excerpt = apply_filters('the_content', $excerpt);
            $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
            $excerpt = strip_tags($excerpt);
            $excerpt_length = apply_filters('excerpt_length', $length);
            $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');

            $words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
            if ( count($words) > $excerpt_length ) {
                array_pop($words);
                $excerpt = implode(' ', $words);
                $excerpt = $excerpt . $excerpt_more;
            } else {
                $excerpt = implode(' ', $words);
            }

            return $excerpt;
        }

        /* =========== PAGES SHORTCODES =============== */

        function course_signup( $atts ) {

            $allowed = array( 'signup', 'login' );

            extract(shortcode_atts(array(
                'page' => isset($_REQUEST['page']) ? $_REQUEST['page'] : '',
                'failed_login_text' => __('Invalid login.', 'cp'),
                'failed_login_class' => 'red',
                'logout_url' => '',
                'signup_title' => __('<h3>Signup</h3>', 'cp'),
                'login_title' => __('<h3>Login</h3>', 'cp'),
                'signup_url' => '',
                'login_url' => '',
                            ), $atts, 'course_signup'));

            $page = in_array($page, $allowed) ? $page : 'signup';

            $signup_url = empty($signup_url) ? '?page=signup' : $signup_url;
            $login_url = empty($login_url) ? '?page=login' : $login_url;

//Set a cookie now to see if they are supported by the browser.
            setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
            if ( SITECOOKIEPATH != COOKIEPATH ) {
                setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);
            };

//Set a redirect for the logout form
            if ( !empty($logout_url) ) {
                update_option('cp_custom_login_url', $logout_url);
            }

            $form_message = '';
            $form_message_class = '';
// Attempt a login if submitted
            if ( isset($_POST['log']) && isset($_POST['pwd']) ) {

                $auth = wp_authenticate_username_password(null, $_POST['log'], $_POST['pwd']);
                if ( !is_wp_error($auth) ) {
// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
                    $user = get_user_by('login', $_POST['log']);
                    $user_id = $user->ID;
                    wp_set_current_user($user_id);
                    wp_set_auth_cookie($user_id);
                    wp_redirect(CoursePress::instance()->get_student_dashboard_slug(true));
                    exit;
                } else {
                    $form_message = $failed_login_text;
                    $form_message_class = $failed_login_class;
                }
            }

            switch ( $page ) {

                case 'signup':

                    if ( !is_user_logged_in() ) {
                        ?>

                        <?php
                        $form_message_class = '';
                        $form_message = '';

                        $student = new Student(0);

                        if ( isset($_POST['student-settings-submit']) ) {

                            check_admin_referer('student_signup');
                            $min_password_length = apply_filters('cp_min_password_length', 6);

                            $student_data = array();
                            $form_errors = 0;

                            do_action('cp_before_signup_validation');

                            if ( $_POST['username'] != '' && $_POST['first_name'] != '' && $_POST['last_name'] != '' && $_POST['email'] != '' && $_POST['password'] != '' && $_POST['password_confirmation'] != '' ) {

                                if ( !username_exists($_POST['username']) ) {

                                    if ( !email_exists($_POST['email']) ) {

                                        if ( $_POST['password'] == $_POST['password_confirmation'] ) {

                                            if ( !preg_match("#[0-9]+#", $_POST['password']) || !preg_match("#[a-zA-Z]+#", $_POST['password']) || strlen($_POST['password']) < $min_password_length ) {
                                                $form_message = sprintf(__('Your password must be at least %d characters long and have at least one letter and one number in it.', 'cp'), $min_password_length);
                                                $form_message_class = 'red';
                                                $form_errors++;
                                            } else {

                                                if ( $_POST['password_confirmation'] ) {
                                                    $student_data['user_pass'] = $_POST['password'];
                                                } else {
                                                    $form_message = __("Passwords don't match", 'cp');
                                                    $form_message_class = 'red';
                                                    $form_errors++;
                                                }
                                            }
                                        } else {
                                            $form_message = __('Passwords don\'t match', 'cp');
                                            $form_message_class = 'red';
                                            $form_errors++;
                                        }

                                        $student_data['role'] = 'student';
                                        $student_data['user_login'] = $_POST['username'];
                                        $student_data['user_email'] = $_POST['email'];
                                        $student_data['first_name'] = $_POST['first_name'];
                                        $student_data['last_name'] = $_POST['last_name'];

                                        if ( !is_email($_POST['email']) ) {
                                            $form_message = __('E-mail address is not valid.', 'cp');
                                            $form_message_class = 'red';
                                            $form_errors++;
                                        }

                                        if ( $form_errors == 0 ) {
                                            if ( $student_id = $student->add_student($student_data) !== 0 ) {
//$form_message = __( 'Account created successfully! You may now <a href="' . ( get_option( 'use_custom_login_form', 1 ) ? trailingslashit( site_url() . '/' . $this->get_login_slug() ) : wp_login_url() ) . '">log into your account</a>.', 'cp' );
//$form_message_class = 'regular';
                                                $email_args['email_type'] = 'student_registration';
                                                $email_args['student_id'] = $student_id;
                                                $email_args['student_email'] = $student_data['user_email'];
                                                $email_args['student_first_name'] = $student_data['first_name'];
                                                $email_args['student_last_name'] = $student_data['last_name'];
                                                coursepress_send_email($email_args);

                                                $creds = array();
                                                $creds['user_login'] = $student_data['user_login'];
                                                $creds['user_password'] = $student_data['user_pass'];
                                                $creds['remember'] = true;
                                                $user = wp_signon($creds, false);

                                                if ( is_wp_error($user) ) {
                                                    $form_message = $user->get_error_message();
                                                    $form_message_class = 'red';
                                                }

// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
                                                if ( isset($_POST['course_id']) && is_numeric($_POST['course_id']) ) {
                                                    $course = new Course($_POST['course_id']);
                                                    wp_redirect($course->get_permalink());
                                                } else {
                                                    wp_redirect(CoursePress::instance()->get_student_dashboard_slug(true));
                                                }
                                                exit;
                                            } else {
                                                $form_message = __('An error occured while creating the account. Please check the form and try again.', 'cp');
                                                $form_message_class = 'red';
                                            }
                                        }
                                    } else {
                                        $form_message = __('User with the same e-mail already exists.', 'cp');
                                        $form_message_class = 'error';
                                    }
                                } else {
                                    $form_message = __('Username already exists. Please choose another one.', 'cp');
                                    $form_message_class = 'red';
                                }
                            } else {
                                $form_message = __('All fields are required.', 'cp');
                                $form_message_class = 'red';
                            }
                        } else {
                            $form_message = __('All fields are required.', 'cp');
                        }
                        ?>
                        <?php
                        if ( !empty($signup_title) ) {
                            echo $signup_title;
                        }
                        ?>

                        <p class="form-info-<?php echo apply_filters('signup_form_message_class', $form_message_class); ?>"><?php echo apply_filters('signup_form_message', $form_message); ?></p>

                        <?php do_action('cp_before_signup_form'); ?>

                        <form id="student-settings" name="student-settings" method="post" class="student-settings">

                            <?php do_action('cp_before_all_signup_fields'); ?>

                            <input type="hidden" name="course_id" value="<?php esc_attr_e(isset($_GET['course_id']) ? $_GET['course_id'] : '' ); ?>" />

                            <label>
                                <?php _e('First Name', 'cp'); ?>:
                                <input type="text" name="first_name" value="<?php echo ( isset($_POST['first_name']) ? $_POST['first_name'] : '' ); ?>" />
                            </label>

                            <?php do_action('cp_after_signup_first_name'); ?>

                            <label>
                                <?php _e('Last Name', 'cp'); ?>:
                                <input type="text" name="last_name" value="<?php echo ( isset($_POST['last_name']) ? $_POST['last_name'] : '' ); ?>" />
                            </label>

                            <?php do_action('cp_after_signup_last_name'); ?>

                            <label>
                                <?php _e('Username', 'cp'); ?>:
                                <input type="text" name="username" value="<?php echo ( isset($_POST['username']) ? $_POST['username'] : '' ); ?>" />
                            </label>

                            <?php do_action('cp_after_signup_username'); ?>

                            <label>
                                <?php _e('E-mail', 'cp'); ?>:
                                <input type="text" name="email" value="<?php echo ( isset($_POST['email']) ? $_POST['email'] : '' ); ?>" />
                            </label>

                            <?php do_action('cp_after_signup_email'); ?>

                            <label>
                                <?php _e('Password', 'cp'); ?>:
                                <input type="password" name="password" value="" />
                            </label>

                            <?php do_action('cp_after_signup_password'); ?>

                            <label class="right">
                                <?php _e('Confirm Password', 'cp'); ?>:
                                <input type="password" name="password_confirmation" value="" />
                            </label>

                            <?php do_action('after_all_signup_fields'); ?>

                            <label class="full">
                                <a href="<?php echo $login_url; ?>"><?php _e('Already have an Account?', 'cp'); ?></a>
                            </label>

                            <label class="full-right">
                                <input type="submit" name="student-settings-submit" class="apply-button-enrolled" value="<?php _e('Create an Account', 'cp'); ?>" />
                            </label>

                            <?php do_action('cp_after_submit'); ?>

                            <?php wp_nonce_field('student_signup'); ?>
                        </form>
                        <div class="clearfix" style="clear: both;" />

                        <?php do_action('cp_after_signup_form'); ?>
                        <?php
                    } else {
//if ( isset( $this ) ) {
//ob_start();
// if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
                        wp_redirect(CoursePress::instance()->get_student_dashboard_slug(true));
                        exit;
//}
                    }

                    break;

                case 'login':
                    ?>
                    <?php
                    if ( !empty($login_title) ) {
                        echo $login_title;
                    }
                    ?>
                    <p class="form-info-<?php echo apply_filters('signup_form_message_class', $form_message_class); ?>"><?php echo apply_filters('signup_form_message', $form_message); ?></p>
                    <?php do_action('cp_before_login_form'); ?>
                    <form name="loginform" id="student-settings" class="student-settings" method="post">
                        <?php do_action('cp_after_start_form_fields'); ?>

                        <label>
                            <?php _e('Username', 'cp'); ?>:
                            <input type="text" name="log" value="<?php echo ( isset($_POST['log']) ? $_POST['log'] : '' ); ?>" />
                        </label>

                        <label>
                            <?php _e('Password', 'cp'); ?>:
                            <input type="password" name="pwd" value="<?php echo ( isset($_POST['pwd']) ? $_POST['pwd'] : '' ); ?>" />
                        </label>

                        <?php do_action('cp_form_fields'); ?>

                        <label class="full">
                            <a href="<?php echo $signup_url; ?>"><?php _e("Don't have an account? Go to Signup!", 'cp'); ?></a>
                        </label>

                        <label class="full-right"><br>
                            <input type="submit" name="wp-submit" id="wp-submit" class="apply-button-enrolled" value="<?php _e('Log In', 'cp'); ?>"><br>
                        </label>
                        <br clear="all" />

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!-- ><input name="rememberme" id="rememberme" value="forever" tabindex="90" type="checkbox"> <span><?php _e('Remember Me?', 'cp'); ?> </span> -->
                        <input name="redirect_to" value="<?php echo CoursePress::instance()->get_student_dashboard_slug(true); ?>" type="hidden">
                        <input name="testcookie" value="1" type="hidden">
                        <input name="course_signup_login" value="1" type="hidden">
                        <?php do_action('cp_before_end_form_fields'); ?>
                    </form>

                    <?php do_action('cp_after_login_form'); ?>			
                    <?php
                    break;
            }
        }

        function module_status( $atts ) {
            extract(shortcode_atts(array( 'format' => true ), $atts));
            $format = ( bool ) $format;

            $is_unit_available = do_shortcode('[course_unit_details field="is_unit_available"]');
            $input_modules_count = do_shortcode('[course_unit_details field="input_modules_count"]');
            $assessable_input_modules_count = do_shortcode('[course_unit_details field="assessable_input_modules_count"]');
            $mandatory_input_elements = do_shortcode('[course_unit_details field="mandatory_input_modules_count"]');
            $mandatory_responses = do_shortcode('[course_unit_details field="student_module_responses" additional="mandatory"]');
            $all_responses = do_shortcode('[course_unit_details field="student_module_responses"]');

            if ( $input_modules_count > 0 ) {
                ?>
                <span class="unit-archive-single-module-status"><?php
                    if ( $is_unit_available ) {
                        if ( $mandatory_input_elements > 0 ) {
                            echo $mandatory_responses;
                            ?> <?php _e('of', 'coursepress'); ?> <?php echo $mandatory_input_elements; ?> <?php
                            _e('mandatory elements completed', 'coursepress');
                        } else {
                            echo $all_responses;
                            ?> <?php _e('of', 'coursepress'); ?> <?php echo $input_modules_count; ?> <?php
                            _e('optional elements completed', 'coursepress');
                        }
                    } else {
                        echo __('Available', 'coursepress') . ' ' . date(get_option('date_format'), strtotime(do_shortcode('[course_unit_details field="unit_availability"]')));
                    }
                    ?></span>
            <?php } else { ?>
                <span class="unit-archive-single-module-status"><?php
                    if ( $is_unit_available ) {
                        _e('Read-only');
                    } else {
                        echo __('Available', 'coursepress') . ' ' . date(get_option('date_format'), strtotime(do_shortcode('[course_unit_details field="unit_availability"]')));
                    }
                    ?></span>
                <?php
            }
        }

        function student_workbook_table( $args ) {
            extract(shortcode_atts(
                            array(
                'module_column_title' => __('Element', 'cp'),
                'title_column_title' => __('Title', 'cp'),
                'submission_date_column_title' => __('Submitted', 'cp'),
                'response_column_title' => __('Answer', 'cp'),
                'grade_column_title' => __('Grade', 'cp'),
                'comment_column_title' => __('Comment', 'cp'),
                'module_response_description_label' => __('Description', 'cp'),
                'comment_label' => __('Comment', 'cp'),
                'view_link_label' => __('View', 'cp'),
                'view_link_class' => 'assessment-view-response-link button button-units',
                'comment_link_class' => 'assessment-view-response-link button button-units',
                'pending_grade_label' => __('Pending', 'cp'),
                'unit_unread_label' => __('Unit Unread', 'cp'),
                'unit_read_label' => __('Unit Read', 'cp'),
                'table_class' => 'widefat shadow-table assessment-archive-table',
                'table_labels_th_class' => 'manage-column'
                            )
                            , $atts));

            $columns = array(
                "module" => $module_column_title,
                "title" => $title_column_title,
                "submission_date" => $submission_date_column_title,
                "response" => $response_column_title,
                "grade" => $grade_column_title,
                "comment" => $comment_column_title,
            );


            $col_sizes = array(
                '15', '30', '15', '10', '13', '5'
            );

            $unit_module_main = new Unit_Module();
            ?>
            <table cellspacing="0" class="<?php echo $table_class; ?>">
                <thead>
                    <tr>
                        <?php
                        $n = 0;
                        foreach ( $columns as $key => $col ) {
                            ?>
                            <th class="<?php echo $table_labels_th_class; ?> column-<?php echo $key; ?>" width="<?php echo $col_sizes[$n] . '%'; ?>" id="<?php echo $key; ?>" scope="col"><?php echo $col; ?></th>
                            <?php
                            $n++;
                        }
                        ?>
                    </tr>
                </thead>

                <?php
                $user_object = new Student(get_current_user_ID());

                $module = new Unit_Module();
                $modules = $module->get_modules(get_the_ID());

                $input_modules_count = 0;

                foreach ( $modules as $mod ) {
                    $class_name = $mod->module_type;
                    if ( class_exists($class_name) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            $input_modules_count++;
                        }
                    }
                }

                $current_row = 0;
                $style = '';
                foreach ( $modules as $mod ) {
                    $class_name = $mod->module_type;

                    if ( class_exists($class_name) ) {
                        $module = new $class_name();

                        if ( $module->front_save ) {
                            $response = $module->get_response($user_object->ID, $mod->ID);
                            $visibility_class = ( count($response) >= 1 ? '' : 'less_visible_row' );

                            if ( count($response) >= 1 ) {
                                $grade_data = $unit_module_main->get_response_grade($response->ID);
                            }

                            if ( isset($_GET['ungraded']) && $_GET['ungraded'] == 'yes' ) {
                                if ( count($response) >= 1 && !$grade_data ) {
                                    $general_col_visibility = true;
                                } else {
                                    $general_col_visibility = false;
                                }
                            } else {
                                $general_col_visibility = true;
                            }

                            $style = ( isset($style) && 'alternate' == $style ) ? '' : ' alternate';
                            ?>
                            <tr id='user-<?php echo $user_object->ID; ?>' class="<?php
                            echo $style;
                            echo 'row-' . $current_row;
                            ?>">

                                <?php
                                if ( $general_col_visibility ) {
                                    ?>
                                    <td class = "<?php echo $style . ' ' . $visibility_class; ?>">
                                        <?php echo $module->label;
                                        ?>
                                    </td>

                                    <td class="<?php echo $style . ' ' . $visibility_class; ?>">
                                        <?php echo $mod->post_title; ?>
                                    </td>

                                    <td class="<?php echo $style . ' ' . $visibility_class; ?>">
                                        <?php echo ( count($response) >= 1 ? date('M d, Y', strtotime($response->post_date)) : __('Not submitted', 'cp') ); ?>
                                    </td>

                                    <td class="<?php echo $style . ' ' . $visibility_class; ?>">
                                        <?php
                                        if ( count($response) >= 1 ) {
                                            ?>
                                            <div id="response_<?php echo $response->ID; ?>" style="display:none;">
                                                <?php if ( isset($mod->post_content) && $mod->post_content !== '' ) { ?>
                                                    <div class="module_response_description">
                                                        <label><?php echo $module_response_description_label; ?></label>
                                                        <?php echo $mod->post_content; ?>
                                                    </div>
                                                <?php } ?>
                                                <?php echo $module->get_response_form(get_current_user_ID(), $mod->ID); ?>

                                                <?php
                                                if ( is_object($response) && !empty($response) ) {

                                                    $comment = $unit_module_main->get_response_comment($response->ID);
                                                    if ( !empty($comment) ) {
                                                        ?>
                                                        <label class="comment_label"><?php echo $comment_label; ?></label>
                                                        <div class="response_comment_front"><?php echo $comment; ?></div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        
                                            <a class="<?php echo $view_link_class; ?> thickbox" href="#TB_inline?width=500&height=300&inlineId=response_<?php echo $response->ID; ?>"><?php echo $view_link_label; ?></a>

                                            <?php
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>

                                    <td class="<?php echo $style . ' ' . $visibility_class; ?>">
                                        <?php
                                        if ( isset($grade_data) ) {
                                            $grade = $grade_data['grade'];
                                            $instructor_id = $grade_data['instructor'];
                                            $instructor_name = get_userdata($instructor_id);
                                            $grade_time = date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $grade_data['time']);
                                        }
                                        if ( count($response) >= 1 ) {
                                            if ( isset($grade_data) ) {
                                                ?>
                                                <?php echo $grade; ?>%
                                                <?php
                                            } else {
                                                echo $pending_grade_label;
                                            }
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>

                                    <td class="<?php echo $style . ' ' . $visibility_class; ?> td-center">
                                        <?php
                                        if ( count($response) >= 1 ) {
                                            $comment = $unit_module_main->get_response_comment($response->ID);
                                        }
                                        if ( isset($comment) && $comment !== '' ) {
                                            ?>
                                            <a alt="<?php echo $comment; ?>" title="<?php echo $comment; ?>" class="<?php echo $comment_link_class; ?> thickbox" href="#TB_inline?width=500&height=300&inlineId=response_<?php echo $response->ID; ?>"><i class="fa fa-comment"></i></a>
                                                <?php
                                            } else {
                                                echo '<i class="fa fa-comment-o"></i>';
                                            }
                                            ?>
                                    </td>
                                <?php }//general col visibility         ?>
                            </tr>
                            <?php
                            $current_row++;
                        }
                    }
                }


                if ( !isset($input_modules_count) || isset($input_modules_count) && $input_modules_count == 0 ) {
                    ?>
                    <tr>
                        <td colspan="7">
                            <?php
                            $unit_grade = do_shortcode('[course_unit_details field="student_unit_grade" unit_id="' . get_the_ID() . '"]');
                            _e('0 input elements in the selected unit.', 'cp');
                            ?>
                            <?php
                            if ( $unit_grade == 0 ) {
                                echo $unit_unread_label;
                            } else {
                                echo $unit_read_label;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }

        public static function instance( $instance = null ) {
            if ( !$instance || 'CoursePress_Shortcodes' != get_class($instance) ) {
                if ( is_null(self::$instance) ) {
                    self::$instance = new CoursePress_Shortcodes();
                }
            } else {
                if ( is_null(self::$instance) ) {
                    self::$instance = $instance;
                }
            }
            return self::$instance;
        }

    }

}

CoursePress_Shortcodes::instance(new CoursePress_Shortcodes());
?>
