<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/completionlib.php');

// Horrible backwards compatible parameter aliasing..
if ($mission = optional_param('mission', 0, PARAM_INT)) {
    $url = $PAGE->url;
    $url->param('section', $mission);
    debugging('Outdated week param passed to course/view.php', DEBUG_DEVELOPER);
    redirect($url);
}
// End backwards-compatible aliasing..

// Make sure section 0 is created.
$context = context_course::instance($course->id);
$course = course_get_format($course)->get_course();
course_create_sections_if_missing($course, 0);

$renderer = $PAGE->get_renderer('format_missions');

if (!empty($displaysection)) {
    $renderer->print_single_section_page($course, null, null, null, null, $displaysection);
} else if (has_capability('moodle/site:config', $context)) {
    $renderer->print_multiple_section_page($course, null, null, null, null);
}

$PAGE->requires->js('/course/format/missions/format.js');
