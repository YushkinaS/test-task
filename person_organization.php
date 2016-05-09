<?php
add_action( 'add_meta_boxes', 'add_organization_metabox');
add_action( 'save_post', 'save_organization_metabox');
add_action( 'wp_ajax_query_organizations', 'query_organizations_callback' );

//Приоритет метабокса высокий, т к это тестовое задание - чтобы не искать его на странице
function add_organization_metabox() {
    add_meta_box('organization', __('Organization', 'casepress'), person_organization_callback, 'persons', 'side', 'high');
}

function person_organization_callback($post) {
 ?>
    <div id="cp_person_organization_wrapper">
        <div>
            <div>
                <label class="cp_label" id="cp_person_organization_label" for="cp_person_organization_input" onclick="">Организация:</label>
            </div>
            <div id="cp_person_organization_edit">
                <div id="cp_person_organization_edit_input">
                    <input type="hidden" id="cp_person_organization_input" name="cp_organization" class="cp_select2_single" />
                </div>  
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                $("#cp_person_organization_input").select2({
                    placeholder: "Выберите организацию",
                    width: '100%',
                    allowClear: true,
                    minimumInputLength: 1,
                    ajax: {
                            url: "<?php echo admin_url('admin-ajax.php') ?>",
                            dataType: 'json',
                            quietMillis: 100,
                            data: function (term, page) { // page is the one-based page number tracked by Select2
                                    return {
                                            action: 'query_organizations',
                                            page_limit: 10, // page size
                                            page: page, // page number
                                            //params: {contentType: "application/json;charset=utf-8"},
                                            q: term //search term
                                    };
                            },
                            results: function (data, page) {
                                    //alert(data.total);
                                    var more = (page * 10) < data.total; // whether or not there are more results available

                                    // notice we return the value of more so Select2 knows if more results can be loaded
                                    return {
                                            results: data.elements,
                                            more: more
                                            };
                            }
                    },
                    
                    formatResult: function(element){ return "<div>" + element.title + "</div>" }, // omitted for brevity, see the source of this page
                    formatSelection: function(element){  return element.title; }, // omitted for brevity, see the source of this page
                    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
                    escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
                });

                //Если есть данные о значении, то делаем выбор
                <?php 
                    $organization_id = get_post_meta( $post->ID, 'cp_organization_id', true );

                    if($organization_id != ''): ?>   
                    $("#cp_person_organization_input").select2(
                        "data", 
                        <?php echo json_encode(array('id' => $organization_id, 'title' => get_the_title($organization_id))); ?>
                    ); 
                <?php endif; ?>


            });
        </script>   
    </div>
    <div>
        <input type="checkbox" id="cp_person_add_organization_checkbox" name="cp_add_organization" />
        <label class="cp_label" for="cp_person_add_organization_checkbox">Добавить организацию</label>
    </div>
    <div>
        <input type="text" id="cp_person_organization_name" name="cp_organization_name" placeholder="Название организации" />
        <textarea id="cp_person_organization_description" name="cp_organization_description" placeholder="Описание"></textarea>
    </div>
    <?php
}

function save_organization_metabox($post_id) {
    $post = get_post($post_id);
    if ('persons' == $post->post_type) { //обязательная проверка на тип поста
        $key = 'cp_organization_id';
        if ( isset( $_REQUEST['cp_organization'] ) ) {
            $data = trim( $_REQUEST['cp_organization'] );
            if( empty($data) ) delete_post_meta($post_id, $key);
            update_post_meta($post_id, $key, $data);
        }

        if ( (isset($_REQUEST['cp_add_organization'])) && (!empty($_REQUEST['cp_organization_name'])) ) {

            $new_organization_title = wp_strip_all_tags($_REQUEST['cp_organization_name']);
            $new_organization_content = wp_strip_all_tags($_REQUEST['cp_organization_description']);
            $new_organization = array(
                'post_type'     => 'organizations',
                'post_status'   => 'publish',
                'post_title'    => $new_organization_title,
                'post_content'  => $new_organization_content
            );
            $new_organization_id = wp_insert_post($new_organization);

            if ( $new_organization_id ) {
                update_post_meta($post_id, $key, $new_organization_id);
            }
        }
    }

}

//Функция ответа JSON для AJAX SELECT2
function query_organizations_callback(){
    $args = array(
        'fields' => 'ids',
        's' => $_GET['q'],
        'paged' => $_GET['page'],
        'posts_per_page' => $_GET['page_limit'],
        'post_type' => 'organizations'
        );

    $query = new WP_Query( $args );

    $elements = array();
    foreach ($query->posts as $post_id){
        $elements[] = array(
            'id' => $post_id,
            'title' => get_the_title($post_id),
            );
    }

    $data[] = array(
        "total" => (int)$query->found_posts,
        'elements' => $elements);

    wp_send_json($data[0]);
}


?>
