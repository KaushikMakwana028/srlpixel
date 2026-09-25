<?php defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getOne($table, $where)
    {
        $query = $this->db->get_where($table, $where);
        return $query->row();
    }


    public function getAll($table, $where = '')
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->result();
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $where, $data)
    {
        return $this->db->update($table, $data, $where);
    }

    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    /**
     * Generic paginated query with where conditions, search likes, order, limit and offset
     * Only fetches the visible slice of data for current page.
     */
    public function get_paginated_data($table, $where = [], $like = [], $limit = 10, $offset = 0, $order_by = 'id DESC', $select = '*')
    {
        $this->db->select($select);
        $this->db->from($table);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($like)) {
            $this->db->group_start();
            $first = true;
            foreach ($like as $field => $val) {
                if ($val !== '' && $val !== null) {
                    if ($first) {
                        $this->db->like($field, $val);
                        $first = false;
                    } else {
                        $this->db->or_like($field, $val);
                    }
                }
            }
            $this->db->group_end();
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }

        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Generic count for filtered paginated query
     */
    public function count_filtered_data($table, $where = [], $like = [])
    {
        $this->db->from($table);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($like)) {
            $this->db->group_start();
            $first = true;
            foreach ($like as $field => $val) {
                if ($val !== '' && $val !== null) {
                    if ($first) {
                        $this->db->like($field, $val);
                        $first = false;
                    } else {
                        $this->db->or_like($field, $val);
                    }
                }
            }
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Generate pagination links array matching exact user specifications:
     * - if First: 1 2 3 ... 9 [Last page]
     * - if middle: 1 ... 4 5 6 ... 9
     * - if Last: 1 ... 7 8 9
     */
    public function generate_pagination_links($current_page, $total_pages)
    {
        if ($total_pages <= 1) {
            return ($total_pages === 1) ? [1] : [];
        }

        if ($total_pages <= 7) {
            $links = [];
            for ($i = 1; $i <= $total_pages; $i++) {
                $links[] = $i;
            }
            return $links;
        }

        // More than 7 pages: user rules
        if ($current_page <= 3) {
            // First: 1 2 3 ... Last
            return [1, 2, 3, '...', $total_pages];
        } elseif ($current_page >= $total_pages - 2) {
            // Last: 1 ... Last-2 Last-1 Last
            return [1, '...', $total_pages - 2, $total_pages - 1, $total_pages];
        } else {
            // Middle: 1 ... C-1 C C+1 ... Last
            return [1, '...', $current_page - 1, $current_page, $current_page + 1, '...', $total_pages];
        }
    }

    /**
     * Render beautiful, mobile-responsive SRL pagination navigation HTML
     */
    public function render_pagination_html($current_page, $total_pages, $total_records, $limit)
    {
        $from = ($total_records == 0) ? 0 : (($current_page - 1) * $limit) + 1;
        $to   = min($current_page * $limit, $total_records);

        $links = $this->generate_pagination_links($current_page, $total_pages);

        $html = '<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 w-100 py-2">';
        
        // Record Counter Info
        $html .= '<div class="text-muted small">';
        $html .= 'Showing <strong class="text-dark">' . $from . '</strong> to <strong class="text-dark">' . $to . '</strong> of <strong class="text-dark">' . number_format($total_records) . '</strong> entries';
        $html .= '</div>';

        // Pagination Buttons
        $html .= '<nav aria-label="Pagination">';
        $html .= '<ul class="pagination pagination-srl mb-0">';

        // Prev Button
        $prev_disabled = ($current_page <= 1) ? 'disabled' : '';
        $prev_page     = max(1, $current_page - 1);
        $html .= '<li class="page-item ' . $prev_disabled . '">';
        $html .= '<a class="page-link" href="#" data-page="' . $prev_page . '" aria-label="Previous">';
        $html .= '<i class="bi bi-chevron-left me-1"></i> Prev';
        $html .= '</a>';
        $html .= '</li>';

        // Numbered Pages & Ellipses
        foreach ($links as $item) {
            if ($item === '...') {
                $html .= '<li class="page-item disabled">';
                $html .= '<span class="page-link dots">&hellip;</span>';
                $html .= '</li>';
            } else {
                $active_class = ($item == $current_page) ? 'active' : '';
                $html .= '<li class="page-item ' . $active_class . '">';
                $html .= '<a class="page-link" href="#" data-page="' . $item . '">' . $item . '</a>';
                $html .= '</li>';
            }
        }

        // Next Button
        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
        $next_page     = min($total_pages, $current_page + 1);
        $html .= '<li class="page-item ' . $next_disabled . '">';
        $html .= '<a class="page-link" href="#" data-page="' . $next_page . '" aria-label="Next">';
        $html .= 'Next <i class="bi bi-chevron-right ms-1"></i>';
        $html .= '</a>';
        $html .= '</li>';

        $html .= '</ul>';
        $html .= '</nav>';
        $html .= '</div>';

        return $html;
    }
    public function getCount($table, $where = [], $isActive = null)
    {
        if (!is_null($isActive)) {
            $where['isActive'] = $isActive;
        }

        if (!empty($where)) {
            $query = $this->db->select()
                ->where($where)
                ->get($table);
        } else {
            $query = $this->db->select()
                ->get($table);
        }

        return $query->num_rows();
    }
    public function getData($table, $selectFields = '*', $where = [])
    {
        $this->db->select($selectFields);
        $this->db->from($table);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCurrentMonthCustomers()
    {
        $query = $this->db->query("
            SELECT * FROM customers 
            WHERE MONTH(purchase_date) = MONTH(CURRENT_DATE()) 
            AND YEAR(purchase_date) = YEAR(CURRENT_DATE())
        ");

        return $query->result_array(); // Returns all matching records as an array
    }
    public function getCustomersAfter90Days()
    {
        $this->db->where('DATE(purchase_date) <=', date('Y-m-d', strtotime('-90 days')));
        $query = $this->db->get('customers');
        return $query->result();
    }
    public function get_all_categories($search = null)
    {
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        return $this->db->order_by('parent_id ASC, name ASC')
            ->get('categories')
            ->result();
    }

    /**
     * Automatically format and sync customer's default address into user.address field
     */
    public function sync_user_default_address($user_id)
    {
        $user_id = (int)$user_id;
        if ($user_id <= 0) return;

        // Fetch default address or first address
        $address = $this->getOne('user_addresses', ['user_id' => $user_id, 'is_default' => 1]);
        if (!$address) {
            $address = $this->getOne('user_addresses', ['user_id' => $user_id]);
        }

        if ($address) {
            $parts = array_filter([
                trim($address->address_line1 ?? ''),
                trim($address->address_line2 ?? ''),
                trim($address->landmark ?? ''),
                trim($address->city ?? ''),
                trim($address->state ?? ''),
                trim($address->pincode ?? '')
            ]);
            $formatted = implode(', ', $parts);
            $this->update('user', ['id' => $user_id], ['address' => $formatted]);
        }
    }
}


