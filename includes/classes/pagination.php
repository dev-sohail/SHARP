<?php
class Pagination {
    public $total; // Total items
    public $page; // Current page
    public $limit; // Items per page
    public $url; // URL template
    public $text; // Results text

    public function render() {
        $totalPages = ceil($this->total / $this->limit);
        if ($totalPages <= 1) return '';

        $output = '<div class="pagination">';

        // Previous Button (Add disabled class if on first page)
        $prevClass = ($this->page == 1) ? 'disabled' : '';
        $prevHref = ($this->page == 1) ? 'javascript:void(0);' : $this->generateUrl($this->page - 1);
        
        $output .= '<a class="prev numb ' . $prevClass . '" href="' . $prevHref . '">
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.0521373 5.26936C0.0859717 5.35557 0.134822 5.43324 0.196259 5.4979L3.75777 9.24594C3.88777 9.38274 4.05875 9.45205 4.2297 9.45205C4.40065 9.45205 4.57163 9.38368 4.70163 9.24594C4.96251 8.9714 4.96251 8.52628 4.70163 8.25174L2.27982 5.7031H14.9142C15.2829 5.7031 15.582 5.38826 15.582 5.00034C15.582 4.61242 15.2829 4.29758 14.9142 4.29758H2.28069L4.7025 1.74894C4.96338 1.47439 4.96338 1.02928 4.7025 0.754736C4.44162 0.480192 4.01866 0.480192 3.75777 0.754736L0.196259 4.50278C0.134822 4.56743 0.0859717 4.64511 0.0521373 4.73131C-0.0155314 4.90372 -0.0155314 5.09695 0.0521373 5.26936Z" fill="#6D863A"/>
                        </svg>
                    </a>';

        // Page Numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $this->page) ? 'page-active' : '';
            $output .= '<a class="page-link numb ' . $activeClass . '" href="' . $this->generateUrl($i) . '">' . $i . '</a>';
        }

        // Next Button (Add disabled class if on last page)
        $nextClass = ($this->page == $totalPages) ? 'disabled' : '';
        $nextHref = ($this->page == $totalPages) ? 'javascript:void(0);' : $this->generateUrl($this->page + 1);
        
        $output .= '<a class="next numb ' . $nextClass . '" href="' . $nextHref . '">
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5299 5.26936C15.4961 5.35557 15.4472 5.43324 15.3858 5.4979L11.8243 9.24594C11.6943 9.38274 11.5233 9.45205 11.3523 9.45205C11.1814 9.45205 11.0104 9.38368 10.8804 9.24594C10.6195 8.9714 10.6195 8.52628 10.8804 8.25174L13.3022 5.7031H6.985H0.667784C0.299167 5.7031 0 5.38826 0 5.00034C0 4.61242 0.299167 4.29758 0.667784 4.29758H13.3013L10.8795 1.74894C10.6187 1.47439 10.6187 1.02928 10.8795 0.754736C11.1404 0.480192 11.5634 0.480192 11.8243 0.754736L15.3858 4.50278C15.4472 4.56743 15.4961 4.64511 15.5299 4.73131C15.5976 4.90372 15.5976 5.09695 15.5299 5.26936Z" fill="#6D863A"/>
                        </svg>
                    </a>';

        $output .= '<div class="cleaner"></div></div>';

        // Results Text
        $start = (($this->page - 1) * $this->limit) + 1;
        $end = min($this->page * $this->limit, $this->total);
        $output .= '<div class="pag_results">' . str_replace(
            ['{start}', '{end}', '{total}', '{pages}'],
            [$start, $end, $this->total, $totalPages],
            $this->text
        ) . '</div>';

        return $output;
    }

    private function generateUrl($page) {
        return str_replace('{page}', $page, $this->url);
    }
}

// Pagination Setup
$pagination = new Pagination();
$pagination->total = 11; // Total items
$pagination->page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$pagination->limit = 3; // Items per page
$pagination->url = '?page={page}';
$pagination->text = 'Showing {start} to {end} of {total} ({pages} Pages)'; // Results text

// Render the pagination HTML
$pagination_html = $pagination->render();
?>
