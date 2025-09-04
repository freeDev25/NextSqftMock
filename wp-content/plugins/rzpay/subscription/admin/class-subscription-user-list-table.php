<?php
if (!class_exists('Subscription_User_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

    class Subscription_User_List_Table extends WP_List_Table {

        public $subscription_id = 0;
        
        public function __construct()
        {
            parent::__construct([
                'singular' => 'subscription_user',
                'plural'   => 'subscription_users',
                'ajax'     => false
            ]);
        }

        public function get_sortable_columns() {
            return [
                'name'         => ['name', false],
                'activated_on' => ['activated_on', false],
                'expire_date'  => ['expire_date', false],
            ];
        }

        public function get_columns()
        {
            return [
                'cb'           => '<input type="checkbox" />',
                'name'         => 'Name',
                'email'        => 'Email',
                'phone'        => 'Phone',
                'status'       => 'Status',
                'activated_on' => 'Activated On',
                'expire_date'  => 'Expire Date',
                'action'       => 'Action',
            ];
        }

        public function column_cb($item)
        {
            return sprintf('<input type="checkbox" name="user[]" value="%s" />', $item['id']);
        }

        public function column_action($item)
        {
            return '<a href="#" class="button">Action</a>';
        }

        public function column_default($item, $column_name)
        {
            return isset($item[$column_name]) ? $item[$column_name] : '';
        }

        public function prepare_items()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'rzpay_user_subscriptions';
            $selected_subscription = $this->subscription_id;

            $per_page = 20;
            $current_page = $this->get_pagenum();
            $offset = ($current_page - 1) * $per_page;

            $orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'created_at';
            $order = (!empty($_REQUEST['order'])) ? sanitize_text_field($_REQUEST['order']) : 'desc';

            $where = $selected_subscription ? $wpdb->prepare('WHERE subscription_id = %d', $selected_subscription) : '';
            $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table $where");
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM $table $where ORDER BY $orderby $order LIMIT %d OFFSET %d",
                $per_page,
                $offset
            ), ARRAY_A);

            $data = [];

            foreach ($results as $row) {
                $user_info = get_userdata($row['user_id']);
                $data[] = [
                    'id'           => $row['id'],
                    'name'         => $user_info ? esc_html($user_info->display_name) : '',
                    'email'        => $user_info ? esc_html($user_info->user_email) : '',
                    'phone'        => esc_html(get_user_meta($row['user_id'], 'phone', true)),
                    'status'       => esc_html($row['status']),
                    'activated_on' => esc_html($row['created_at']),
                    'expire_date'  => esc_html($row['subscription_end_date']),
                    'action'       => '',
                ];
            }

            $this->items = $data;
            $this->_column_headers = array(
                $this->get_columns(),        // columns
                array(),            // hidden
                $this->get_sortable_columns(),    // sortable
            );
            $this->set_pagination_args([
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil($total_items / $per_page)
            ]);
        }
    }
}
