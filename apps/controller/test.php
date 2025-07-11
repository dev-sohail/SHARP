<?php
class ControllerTest extends Controller
{
    public function index()
    {
        $this->load_model('test');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            try {
                $action = $_POST['action'] ?? '';
                $video_id = $_POST['video_id'] ?? '';

                if (empty($video_id) || !ctype_digit($video_id)) {
                    throw new Exception('Invalid video ID');
                }

                $video_id = (int)$video_id;
                $model = $this->model_test;

                if ($action === 'save') {
                    $resumetime = isset($_POST['resumetime']) ? (float)$_POST['resumetime'] : 0;
                    $success = $model->saveResumetime($video_id, $resumetime);

                    echo json_encode([
                        'success' => $success,
                        'error' => $success ? '' : 'Failed to save resumetime'
                    ]);
                } elseif ($action === 'load') {
                    $video = $model->getVideo($video_id);

                    // print_r($video);exit;
                    if ($video) {
                        echo json_encode([
                            'success' => true,
                            'resumetime' => (float)$video['resumetime'],
                            'video_url' => $video['video_url']
                        ]);
                    // print($video['video_url']);exit;
                    } else {
                        echo json_encode([
                            'success' => false,
                            'error' => 'No video found'
                        ]);
                    }
                } else {
                    throw new Exception('Invalid action');
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            exit;
        }

        // Template handling
        $template_path = 'food/template/test.tpl';
        if (!file_exists(DIR_TEMPLATE . $template_path)) {
            error_log('Template file not found: ' . $template_path);
            $template_path = 'food/error404.tpl';
        }

        $this->template = $template_path;
        $this->zones = array('header_new');
        $this->response->setOutput($this->render());
    }
}
