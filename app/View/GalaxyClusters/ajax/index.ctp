<?php
    echo $this->element('/genericElements/IndexTable/index_table', array(
        'data' => array(
            'paginatorOptions' => array(
                'update' => '#clusters_div',
            ),
            'data' => $list,
            'top_bar' => array(
                'children' => array(
                    array(
                        'type' => 'simple',
                        'children' => array(
                            array(
                                'active' => $context === 'all',
                                'url' => sprintf('%s/galaxies/view/%s/context:all', $baseurl, $galaxy_id),
                                'text' => __('All'),
                            ),
                            array(
                                'active' => $context === 'default',
                                'url' => sprintf('%s/galaxies/view/%s/context:default', $baseurl, $galaxy_id),
                                'text' => __('Default Galaxy Clusters'),
                            ),
                            array(
                                'active' => $context === 'custom',
                                'url' => sprintf('%s/galaxies/view/%s/context:custom', $baseurl, $galaxy_id),
                                'text' => __('Custom Galaxy Clusters'),
                            ),
                            array(
                                'active' => $context === 'org',
                                'url' => sprintf('%s/galaxies/view/%s/context:org', $baseurl, $galaxy_id),
                                'text' => __('My Galaxy Clusters'),
                            ),
                            array(
                                'active' => $context === 'fork_tree',
                                'url' => sprintf('%s/galaxies/view/%s/context:fork_tree', $baseurl, $galaxy_id),
                                'text' => __('View Fork Tree'),
                            ),
                            array(
                                'active' => $context === 'relations',
                                'url' => sprintf('%s/galaxies/view/%s/context:relations', $baseurl, $galaxy_id),
                                'text' => __('View Galaxy Relationships'),
                            ),
                        )
                    ),
                    array(
                        'type' => 'search',
                        'button' => __('Filter'),
                        'placeholder' => __('Enter value to search'),
                        'data' => '',
                    )
                )
            ),
            'fields' => array(
                array(
                    'name' => __('Value'),
                    'sort' => 'GalaxyCluster.value',
                    'element' => 'links',
                    'class' => 'short',
                    'data_path' => 'GalaxyCluster.value',
                    'url_params_data_paths' => 'GalaxyCluster.id',
                    'url' => $baseurl . '/galaxy_clusters/view'
                ),
                array(
                    'name' => __('Synonyms'),
                    'sort' => 'name',
                    'class' => '',
                    'data_path' => 'GalaxyCluster.synonyms',
                ),
                array(
                    'name' => __('Owner Org'),
                    'class' => 'short',
                    'element' => 'org',
                    'data_path' => 'Org',
                    'fields' => array(
                        'allow_picture' => true,
                        'default_org' => 'MISP'
                    ),
                    'requirement' => $isSiteAdmin || (Configure::read('MISP.showorgalternate') && Configure::read('MISP.showorg'))
                ),
                array(
                    'name' => __('Creator Org'),
                    'class' => 'short',
                    'element' => 'org',
                    'data_path' => 'Orgc',
                    'fields' => array(
                        'allow_picture' => true,
                        'default_org' => 'MISP'
                    ),
                    'requirement' => (Configure::read('MISP.showorg') || $isAdmin) || (Configure::read('MISP.showorgalternate') && Configure::read('MISP.showorg'))
                ),
                array(
                    'name' => __('Default'),
                    'class' => 'short',
                    'element' => 'boolean',
                    'data_path' => 'GalaxyCluster.default',
                ),
                array(
                    'name' => __('Activity'),
                    'class' => 'short',
                    'data_path' => 'GalaxyCluster.id',
                    'csv' => array('scope' => 'cluster', 'data' => $csv),
                    'element' => 'sparkline'
                ),
                array(
                    'name' => __('#Events'),
                    'class' => 'short',
                    'data_path' => 'GalaxyCluster.event_count',
                ),
                array(
                    'name' => __('#Relations'),
                    'class' => 'short',
                    'data_path' => 'GalaxyCluster.relation_counts',
                    'element' => 'relation_counts'
                ),
                array(
                    'name' => __('Description'),
                    'sort' => 'description',
                    'data_path' => 'GalaxyCluster.description',
                    'element' => 'extended',
                    'fields' => array(
                        'extend_data' => array(
                            0 => array(
                                'extend_root_data_path' => 'GalaxyCluster.extended_from',
                                'extend_link_path' => 'GalaxyCluster.uuid',
                                'extend_link_title' => 'GalaxyCluster.value',
                            ),
                            1 => array(
                                'extend_root_data_path' => 'GalaxyCluster',
                                'extend_link_title' => 'value',
                            ),
                            2 => array(
                                'extend_root_data_path' => 'GalaxyCluster.extended_by',
                                'extend_link_path' => 'GalaxyCluster.uuid',
                                'extend_link_title' => 'GalaxyCluster.value',
                            ),
                        )
                    )
                ),
                array(
                    'name' => __('Distribution'),
                    'sort' => 'distribution',
                    'data_path' => 'GalaxyCluster.distribution',
                    'element' => 'distribution_levels'
                ),
            ),
            'actions' => array(
                array(
                    'title' => 'View correlation graph',
                    'url' => '/galaxies/viewGraph',
                    'url_params_data_paths' => array(
                        'GalaxyCluster.id'
                    ),
                    'icon' => 'share-alt',
                ),
                array(
                    'title' => 'View',
                    'url' => '/galaxy_clusters/view',
                    'url_params_data_paths' => array(
                        'GalaxyCluster.id'
                    ),
                    'icon' => 'eye',
                    'dbclickAction' => true
                ),
                array(
                    'title' => 'Fork',
                    'url' => '/galaxy_clusters/add',
                    'url_params_data_paths' => array(
                        'GalaxyCluster.galaxy_id'
                    ),
                    'url_named_params_data_paths' => array(
                        'forkUuid' => 'GalaxyCluster.uuid'
                    ),
                    'icon' => 'code-branch'
                ),
                array(
                    'title' => 'Edit',
                    'url' => '/galaxy_clusters/edit',
                    'url_params_data_paths' => array(
                        'GalaxyCluster.id'
                    ),
                    'icon' => 'edit',
                    'complex_requirement' => array(
                        'function' => function($row, $options) {
                            return ($options['me']['org_id'] == $options['datapath']['org']);
                        },
                        'options' => array(
                            'me' => $me,
                            'datapath' => array(
                                'org' => 'GalaxyCluster.org_id'
                            )
                        )
                    ),
                ),
                array(
                    'title' => 'Delete',
                    'url' => '/galaxy_clusters/delete',
                    'url_params_data_paths' => array(
                        'GalaxyCluster.id'
                    ),
                    'postLink' => true,
                    'postLinkConfirm' => __('Are you sure you want to delete the Galaxy Cluster?'),
                    'icon' => 'trash'
                ),
            )
        )
    ));
?>

<script type="text/javascript">
    $(document).ready(function(){
        var passedArgsArray = <?php echo $passedArgs; ?>;
        var galaxyId = "<?php echo h($galaxy_id); ?>";
        if (passedArgsArray['context'] === undefined || passedArgsArray['context'] === "") {
            passedArgsArray['context'] = 'all';
        }
        $('#quickFilterButton').click(function() {
            runIndexQuickFilter('/' + galaxyId + '/context:' + passedArgsArray['context']);
        });
        $('#quickFilterField').on('keypress', function (e) {
            if(e.which === 13) {
                runIndexQuickFilter('/' + galaxyId + '/context:' + passedArgsArray['context']);
            }
        });
    });
</script>
<?php echo $this->Js->writeBuffer(); ?>
