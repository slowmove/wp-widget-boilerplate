<?php
class Custom_Widget extends WP_Widget {

  function __construct() {
    parent::__construct('custom_widget', 'Custom Widget Name');
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget($args, $instance) {
    extract($args);

    $post_id = $instance['post_id'];
    $p = get_post($post_id);

    echo $before_widget;
        echo $before_title . $p->post_title . $after_title;        
        echo '<a href="' . get_permalink($p->ID) . '">Läs mer</a>';
    echo $after_widget;
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['post_id'] = strip_tags($new_instance['post_id']);

    return $instance;
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form($instance) {
    if (isset($instance['post_id'])) {
      $post_id = $instance['post_id'];
    } else {
      $post_id = __('Sida', 'text_domain');
    }
    $args = array('post_type' => array('post', 'page', 'inlagg', 'nyhetsinlagg', 'artiklar', 'forskningsartikel', 'fragasvar'), 'posts_per_page' => 10000);
    $loop = new WP_Query($args);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('post_id'); ?>"><?php _e('Välj Sida:'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('post_id'); ?>" name="<?php echo $this->get_field_name('post_id'); ?>">
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
          <?php global $post; ?>
          <option value="<?php echo $post->ID ?>"><?php echo the_title(); ?></option>
        <?php endwhile; ?>
      </select>
    </p>
    <?php
  }

}

/**
 * Then register
 */
register_widget('custom_widget');