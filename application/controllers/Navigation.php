<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * GET /api/common/navigation
     */
    public function index()
    {
        // -----------------------------
        // SAME DATA AS data.ts
        // -----------------------------


        if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }

        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
        //print_r($tokenData->Role);exit ;   //  To do  if  $tokenData->Role ==  'Super Administrator'  

        $role = trim(strtolower($tokenData->Role ?? ''));
        $isAdmin = in_array($role, ['super administrator', 'administrator', 'admin'], true);
        // Front desk & nurse share the same reception-focused menu (see note “FRONT DESK & NURSE”).
        $isFrontDesk = in_array($role, [
            'front desk',
            'registration clerk',
            'nurse',
            'staff nurse',
            'registered nurse',
        ], true);

        // Facility admin & group admin: dashboards + Administration only (per spec).
        $isGroupAdmin = in_array($role, [
            'group administrator',
            'group admin',
        ], true);
        $isFacilityAdmin = in_array($role, [
            'facility administrator',
            'facility admin',
        ], true);

        $tenantId = $tokenData->TenantId;

        /*
         * Default navigation (Fuse `default` array):
         * - Front desk & nurse: reception-focused menu only (Registration, Dispense, Billing, etc.).
         * - Group admin: Facility + Group dashboards; Administration with Facilities + full facility masters.
         * - Facility admin: Facility Admin dashboard only; Administration with facility masters (no Facilities list).
         * - Administrator (global): standard menu below + admin-only entries (ads, vouchers, etc.).
         * - Other roles (e.g. doctor): standard menu only, no admin extras.
         */
        if ($isFrontDesk) {
            // Administration → Facility Management: only Item / Package / Inventory for front desk & nurse.
            $administrationChildren = [
                [
                    'title' => 'Facility Management',
                    'type' => 'collapsable',
                    'icon' => 'mat_solid:view_list',
                    'children' => [
                        [
                            'title' => 'Item Master',
                            'type' => 'basic',
                            'icon' => 'mat_solid:star',
                            'externalLink' => true,
                            'link' => 'https://internal.ring.healthcare/Administration/ItemMaster',
                        ],
                        [
                            'title' => 'Package Master',
                            'type' => 'basic',
                            'icon' => 'mat_solid:star',
                            'link' => 'package/list',
                        ],
                        [
                            'title' => 'Inventory',
                            'type' => 'basic',
                            'icon' => 'mat_solid:star',
                            'link' => 'inventory/item-stock',
                        ],
                    ],
                ],
                [
                    'title' => 'User Management',
                    'type' => 'collapsable',
                    'icon' => 'mat_solid:calendar_view_day',
                    'children' => [
                        [
                            'title' => 'Users',
                            'type' => 'basic',
                            'icon' => 'mat_solid:calendar_view_day',
                            'externalLink' => true,
                            'link' => 'https://internal.ring.healthcare/Administration/User',
                        ],
                    ],
                ],
            ];

            $defaultNavigation = [
                [
                    'type' => 'group',
                    'icon' => 'heroicons_solid:home',
                    'children' => [
                        [
                            'no' => 1,
                            'id' => 'dashboards',
                            'title' => 'Dashboard',
                            'type' => 'basic',
                            'icon' => 'heroicons_solid:chart-pie',
                            'link' => '/dashboards/frontdashboard',
                        ],
                        [
                            'no' => 2,
                            'title' => 'Registration',
                            'type' => 'collapsable',
                            'icon' => 'mat_solid:login',
                            'children' => [
                                [
                                    'title' => 'Calendar',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:calendar',
                                    'link' => '/doctor-appointment',
                                ],
                                [
                                    'title' => 'Appointment',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:calendar',
                                    'externalLink' => true,
                                    'link' => 'https://internal.ring.healthcare/Enrollment/Appointment'
                                ],
                                [
                                    'title' => 'Queue Management',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:pencil-square',
                                    'externalLink' => true,
                                    'link' => 'https://internal.ring.healthcare/Enrollment/Enrollment',
                                ],
                            ],
                        ],
                        [
                            'no' => 4,
                            'id' => 'dispense',
                            'title' => 'Dispense',
                            'type' => 'basic',
                            'icon' => 'mat_solid:local_pharmacy',
                            'externalLink' => true,
                            'link' => 'https://internal.ring.healthcare/Billing/Pharmacy',
                        ],
                        [
                            'no' => 5,
                            'title' => 'Billing',
                            'type' => 'collapsable',
                            'icon' => 'mat_solid:view_list',
                            'children' => [
                                [
                                    'title' => 'Charges & Bill',
                                    'type' => 'basic',
                                    'icon' => 'mat_solid:view_list',
                                    'externalLink' => true,
                                    'link' => 'https://internal.ring.healthcare/Billing/ChargeEntryHeader',
                                ],
                                [
                                    'title' => 'Package Purchase',
                                    'type' => 'basic',
                                    'icon' => 'mat_solid:view_list',
                                    'externalLink' => true,
                                    'link' => 'https://internal.ring.healthcare/Billing/PackagePurchase',
                                ],
                            ],
                        ],
                        [
                            'no' => 6,
                            'title' => 'MR Digital Transfer',
                            'type' => 'basic',
                            'icon' => 'heroicons_solid:arrows-right-left',
                            'externalLink' => true,
                            'link' => 'https://internal.ring.healthcare/DigitalTransfer/DigitalTransfer',
                        ],
                        [
                            'no' => 8,
                            'title' => 'Administration',
                            'type' => 'collapsable',
                            'icon' => 'heroicons_solid:cog-6-tooth',
                            'children' => $administrationChildren,
                        ],
                    ],
                ],
            ];
        } elseif ($isGroupAdmin) {
            $facilityMgmtChildren = [
                [
                    'title' => 'Facilities',
                    'type' => 'basic',
                    'icon' => 'mat_solid:apartment',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/Tenant',
                ],
                [
                    'title' => 'Department Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/DepartmentMaster',
                ],
                [
                    'title' => 'Service Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/ServiceMaster',
                ],
                [
                    'title' => 'Item Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/ItemMaster',
                ],
                [
                    'title' => 'Package Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:fact_check',
                    'link' => 'package/list',
                ],
                [
                    'title' => 'Inventory',
                    'type' => 'basic',
                    'icon' => 'mat_solid:inventory_2',
                    'link' => 'inventory/item-stock',
                ],
            ];

            $defaultNavigation = [
                [
                    'type' => 'group',
                    'icon' => 'heroicons_solid:home',
                    'children' => [
                        [
                            'no' => 1,
                            'id' => 'dashboards',
                            'title' => 'Dashboard',
                            'type' => 'collapsable',
                            'icon' => 'heroicons_solid:chart-pie',
                            'children' => [
                                [
                                    'title' => 'Facility Admin Dashboard',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:chart-pie',
                                    'link' => '/dashboards/project',
                                ],
                                [
                                    'title' => 'Group Admin Dashboard',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:squares-2x2',
                                    'link' => '/dashboards/group-admin',
                                ],
                            ],
                        ],
                        [
                            'no' => 8,
                            'title' => 'Administration',
                            'type' => 'collapsable',
                            'icon' => 'heroicons_solid:cog-6-tooth',
                            'children' => [
                                [
                                    'title' => 'Facility Management',
                                    'type' => 'collapsable',
                                    'icon' => 'mat_solid:view_list',
                                    'children' => $facilityMgmtChildren,
                                ],
                                [
                                    'title' => 'User Management',
                                    'type' => 'collapsable',
                                    'icon' => 'mat_solid:calendar_view_day',
                                    'children' => [
                                        [
                                            'title' => 'Users',
                                            'type' => 'basic',
                                            'icon' => 'mat_solid:calendar_view_day',
                                            'externalLink' => true,
                                            'link' => 'https://internal.ring.healthcare/Administration/User',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        } elseif ($isFacilityAdmin) {
            $facilityMgmtChildren = [
                [
                    'title' => 'Department Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/DepartmentMaster',
                ],
                [
                    'title' => 'Service Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/ServiceMaster',
                ],
                [
                    'title' => 'Item Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:star',
                    'externalLink' => true,
                    'link' => 'https://internal.ring.healthcare/Administration/ItemMaster',
                ],
                [
                    'title' => 'Package Master',
                    'type' => 'basic',
                    'icon' => 'mat_solid:fact_check',
                    'link' => 'package/list',
                ],
                [
                    'title' => 'Inventory',
                    'type' => 'basic',
                    'icon' => 'mat_solid:inventory_2',
                    'link' => 'inventory/item-stock',
                ],
            ];

            $defaultNavigation = [
                [
                    'type' => 'group',
                    'icon' => 'heroicons_solid:home',
                    'children' => [
                        [
                            'no' => 1,
                            'id' => 'dashboards',
                            'title' => 'Dashboard',
                            'type' => 'collapsable',
                            'icon' => 'heroicons_solid:chart-pie',
                            'children' => [
                                [
                                    'title' => 'Facility Admin Dashboard',
                                    'type' => 'basic',
                                    'icon' => 'heroicons_solid:chart-pie',
                                    'link' => '/dashboards/project',
                                ],
                            ],
                        ],
                        [
                            'no' => 8,
                            'title' => 'Administration',
                            'type' => 'collapsable',
                            'icon' => 'heroicons_solid:cog-6-tooth',
                            'children' => [
                                [
                                    'title' => 'Facility Management',
                                    'type' => 'collapsable',
                                    'icon' => 'mat_solid:view_list',
                                    'children' => $facilityMgmtChildren,
                                ],
                                [
                                    'title' => 'User Management',
                                    'type' => 'collapsable',
                                    'icon' => 'mat_solid:calendar_view_day',
                                    'children' => [
                                        [
                                            'title' => 'Users',
                                            'type' => 'basic',
                                            'icon' => 'mat_solid:calendar_view_day',
                                            'externalLink' => true,
                                            'link' => 'https://internal.ring.healthcare/Administration/User',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        } else {
            $defaultNavigation = [
                [
                    'type' => 'group',
                    'icon' => 'heroicons_solid:home',
                    'children' => [
                    [
                        'no' => 1,
                        'id' => 'dashboards',
                        'title' => 'Dashboard',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:chart-pie',
                        'link' => '/dashboards/drdashboard',
                    ],
                    [
                        'no' => 2,
                        'title' => 'Registration',
                        'type' => 'collapsable',
                        'icon' => 'mat_solid:login',
                        'children' => [

                            [
                                'title' => 'Calendar',
                                'type' => 'basic',
                                'icon' => 'heroicons_solid:calendar',
                                'link' => '/doctor-appointment',
                            ],


                          

                            [
                                'title' => 'Appointment', 
                                'type' => 'basic', 
                                'icon' => 'heroicons_solid:calendar',
                                 'externalLink' => true,
                                 'link' => 'https://internal.ring.healthcare/Enrollment/Appointment'
                                ],
                              [
                                'title' => 'Queue Management',
                                'type' => 'basic',
                                'icon' => 'heroicons_solid:pencil-square',
                                'externalLink' => true,
                                'link' => 'https://internal.ring.healthcare/Enrollment/Enrollment',
                            ],
                        ],
                    ],
                    [
                        'no' => 3,
                        'title' => 'MR Digital Transfer',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:arrows-right-left',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/DigitalTransfer/DigitalTransfer',
                    ],
                    [
                        'no' => 4,
                        'title' => 'Clinical Management',
                        'type' => 'collapsable',
                        'icon' => 'mat_solid:login',
                        'children' => [
                            [
                                'title' => 'My Queue',
                                'type' => 'basic',
                                'icon' => 'heroicons_solid:user-group',
                                'externalLink' => true,
                                'link' => 'https://internal.ring.healthcare/Clinical/OutPatient',
                            ],
                        ],
                    ],
                    [
                        'no' => 5,
                        'title' => 'eReferrals Received',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:arrow-trending-up',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Referral/Referral',
                    ],
                    [
                        'no' => 6,
                        'title' => 'eReferrals Sent',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:arrow-trending-up',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare//DigitalTransfer/EReferralStatus',
                    ],
                    [
                        'no' => 81,
                        'title' => 'Administration',
                        'type' => 'collapsable',
                        'icon' => 'heroicons_solid:cog-6-tooth',
                        'children' => [
                            [
                                'title' => 'Facility Management',
                                'type' => 'collapsable',
                                'icon' => 'mat_solid:calendar_view_day',
                                'children' => [
                                    [
                                        'title' => 'Service Master',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:star',
                                        'externalLink' => true,
                                        'link' => 'https://internal.ring.healthcare/Administration/ServiceMaster',
                                    ],
                                    [
                                        'title' => 'Item Master',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:star',
                                        'externalLink' => true,
                                        'link' => 'https://internal.ring.healthcare/Administration/ItemMaster',
                                    ],
                                    [
                                        'title' => 'Department Master',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:star',
                                        'externalLink' => true,
                                        'link' => 'https://internal.ring.healthcare/Administration/DepartmentMaster',
                                    ],
                                    [
                                        'title' => 'Inventory',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:inventory_2',
                                        'link' => 'inventory/item-stock',
                                    ],
                                    [
                                        'title' => 'Package Master',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:fact_check',
                                        'link' => 'package/list',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'User Management',
                                'type' => 'collapsable',
                                'icon' => 'mat_solid:calendar_view_day',
                                'children' => [
                                    [
                                        'title' => 'Users',
                                        'type' => 'basic',
                                        'icon' => 'mat_solid:calendar_view_day',
                                        'externalLink' => true,
                                        'link' => 'https://internal.ring.healthcare/Administration/User',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'no' => 80,
                        'title' => 'Billing',
                        'type' => 'collapsable',
                        'icon' => 'mat_solid:notifications',
                        'children' => [
                            [
                                'title' => 'Charges & Bill Detail',
                                'type' => 'basic',
                                'icon' => 'mat_solid:calendar_view_day',
                                'externalLink' => true,
                                'link' => 'https://internal.ring.healthcare/Billing/ChargeEntryHeader',
                            ],
                        ],
                    ],
                ],
            ],
        ];

            if ($isAdmin) {




            // -----------------------------
            // Advertisements (Admin only)
            // -----------------------------
            $defaultNavigation[0]['children'][] = [
                'no' => 9,
                'id' => 'advertisements',
                'title' => 'Advertisements',
                'type' => 'collapsable',
                'icon' => 'mat_solid:notifications', // fa-bell equivalent
                'children' => [
                    [
                        'title' => 'Create New',
                        'type' => 'basic',
                        'icon' => 'mat_solid:storage',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Administration/Advertisements',
                    ],
                    [
                        'title' => 'Active',
                        'type' => 'basic',
                        'icon' => 'mat_solid:storage',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Administration/ActiveAdvertisements',
                    ],
                    [
                        'title' => 'Scheduled',
                        'type' => 'basic',
                        'icon' => 'mat_solid:storage',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Administration/ScheduledAdvertisements',
                    ],
                    [
                        'title' => 'Drafts',
                        'type' => 'basic',
                        'icon' => 'mat_solid:storage',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Administration/Drafts',
                    ],
                    [
                        'title' => 'History',
                        'type' => 'basic',
                        'icon' => 'mat_solid:storage',
                        'externalLink' => true,
                        'link' => 'https://internal.ring.healthcare/Administration/AdvertisementsHistory',
                    ],
                ],
            ];

            // -----------------------------
            // Vouchers (Admin only)
            // -----------------------------
            $defaultNavigation[0]['children'][] = [
                'no' => 10,
                'id' => 'vouchers',
                'title' => 'Vouchers',
                'type' => 'basic',
                'icon' => 'mat_solid:local_offer', // similar to fa-tags
                'externalLink' => true,
                'link' => 'https://internal.ring.healthcare/Administration/Vouchers',
            ];


            // Add Premium Services
            $defaultNavigation[0]['children'][] = [
                'no' => 11,
                'id' => 'premium-services-master',
                'title' => 'Premium Services',
                'type' => 'basic',
                'icon' => 'mat_solid:star',
                'externalLink' => true,
                'link' => 'https://internal.ring.healthcare/PremiumServices/PremiumServicesMaster',
            ];


            // Add Pharmacy
            $defaultNavigation[0]['children'][] = [
                'no' => 90,
                'id' => 'pharmacy',
                'title' => 'Pharmacy',
                'type' => 'basic',
                'icon' => 'mat_solid:local_pharmacy',
                'externalLink' => true,
                'link' => 'https://internal.ring.healthcare/Billing/Pharmacy',
            ];


            }

        }

        // Sort default nav group children
        if (isset($defaultNavigation[0]['children'])) {
            $this->_sort_nav_by_no($defaultNavigation[0]['children']);
        }


        $compactNavigation = [
            [

                'id' => 'dashboards',
                'title' => 'Dashboards',
                'tooltip' => 'Dashboards',
                'type' => 'aside',
                'icon' => 'heroicons_solid:home',
                'children' => [],
            ],
            [
                'id' => 'apps',
                'title' => 'Apps',
                'tooltip' => 'Apps',
                'type' => 'aside',
                'icon' => 'heroicons_solid:squares-2x2',
                'children' => [],
            ],
            [
                'id' => 'pages',
                'title' => 'Pages',
                'tooltip' => 'Pages',
                'type' => 'aside',
                'icon' => 'heroicons_solid:document-duplicate',
                'children' => [],
            ],
            [
                'id' => 'user-interface',
                'title' => 'UI',
                'tooltip' => 'UI',
                'type' => 'aside',
                'icon' => 'heroicons_solid:rectangle-stack',
                'children' => [],
            ],
            [
                'id' => 'navigation-features',
                'title' => 'Navigation',
                'tooltip' => 'Navigation',
                'type' => 'aside',
                'icon' => 'heroicons_solid:bars-3',
                'children' => [],
            ],
        ];

        $futuristicNavigation = [
            [
                'id' => 'dashboards',
                'title' => 'DASHBOARDS',
                'type' => 'group',
                'children' => [],
            ],
            [
                'id' => 'apps',
                'title' => 'APPS',
                'type' => 'group',
                'children' => [],
            ],
            [
                'id' => 'others',
                'title' => 'OTHERS',
                'type' => 'group',
            ],
            [
                'id' => 'pages',
                'title' => 'Pages',
                'type' => 'aside',
                'icon' => 'heroicons_solid:document-duplicate',
                'children' => [],
            ],
            [
                'id' => 'user-interface',
                'title' => 'User Interface',
                'type' => 'aside',
                'icon' => 'heroicons_solid:rectangle-stack',
                'children' => [],
            ],
            [
                'id' => 'navigation-features',
                'title' => 'Navigation Features',
                'type' => 'aside',
                'icon' => 'heroicons_solid:bars-3',
                'children' => [],
            ],
        ];

        $horizontalNavigation = [
            [
                'id' => 'dashboards',
                'title' => 'Dashboards',
                'type' => 'collapsable',
                'icon' => 'heroicons_solid:chart-pie',
                'children' => [
                    [
                        'title' => 'Admin Dashboard',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:user',
                        'link' => '/dashboards/project',
                    ],
                    [
                        'title' => 'Doctor Dashboard',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:users',
                        'link' => '/dashboards/drdashboard',
                    ],
                    [
                        'title' => 'Front Desk Dashboard',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:chart-pie',
                        'link' => '/dashboards/frontdashboard',
                    ],
                ],
            ],
            [
                'id' => 'registration',
                'title' => 'Registration',
                'type' => 'group',
                'icon' => 'mat_solid:login',
                'children' => [
                    [
                        'title' => 'Appointment',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:calendar',
                        'externalLink' => true,
                         'link' => 'https://internal.ring.healthcare/Enrollment/Appointment'
                    ],
                    [
                        'title' => 'Queue Management',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:pencil-square',
                    ],
                ],
            ],
            [
                'id' => 'mrdigitaltransfer',
                'title' => 'MR Digital Transfer',
                'type' => 'basic',
                'icon' => 'heroicons_solid:arrows-right-left',
            ],
            [
                'id' => 'clinicalmanagement',
                'title' => 'Clinical Management',
                'type' => 'group',
                'icon' => 'mat_solid:login',
                'children' => [
                    [
                        'title' => 'My Queue',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:user-group',
                    ],
                    [
                        'title' => 'Billing',
                        'type' => 'basic',
                        'icon' => 'mat_solid:calendar_view_day',
                    ],
                    [
                        'title' => 'eReferrals Sent',
                        'type' => 'basic',
                        'icon' => 'heroicons_solid:arrow-trending-up',
                    ],
                ],
            ],
            [
                'id' => 'administration',
                'title' => 'Administration',
                'type' => 'group',
                'icon' => 'heroicons_solid:cog-6-tooth',
                'children' => [
                    [
                        'title' => 'Facility Management',
                        'type' => 'basic',
                        'icon' => 'mat_solid:calendar_view_day',
                    ],
                    [
                        'title' => 'User Management',
                        'type' => 'basic',
                        'icon' => 'mat_solid:calendar_view_day',
                    ],
                ],
            ],
            [
                'id' => 'advertisements',
                'title' => 'Advertisements',
                'type' => 'group',
                'icon' => 'mat_solid:notifications',
                'children' => [
                    ['title' => 'Create New', 'type' => 'basic', 'icon' => 'mat_solid:calendar_view_day'],
                    ['title' => 'Active', 'type' => 'basic', 'icon' => 'mat_solid:calendar_view_day'],
                    ['title' => 'Scheduled', 'type' => 'basic', 'icon' => 'mat_solid:calendar_view_day'],
                    ['title' => 'Drafts', 'type' => 'basic', 'icon' => 'mat_solid:calendar_view_day'],
                    ['title' => 'History', 'type' => 'basic', 'icon' => 'mat_solid:calendar_view_day'],
                ],
            ],
            [
                'title' => 'Vouchers',
                'type' => 'basic',
                'icon' => 'mat_solid:local_offer',
            ],
            [
                'title' => 'Premium Services',
                'type' => 'basic',
                'icon' => 'mat_solid:star',
            ],
        ];

        // -----------------------------
        // OPTIONAL: match Fuse mock behavior:
        // fill children from defaultNavigation by matching id
        // -----------------------------
        $compactNavigation = $this->_fill_children_from_default($compactNavigation, $defaultNavigation);
        $futuristicNavigation = $this->_fill_children_from_default($futuristicNavigation, $defaultNavigation);
        $horizontalNavigation = $this->_fill_children_from_default($horizontalNavigation, $defaultNavigation);

        $payload = [
            'compact' => $compactNavigation,
            'default' => $defaultNavigation,
            'futuristic' => $futuristicNavigation,
            'horizontal' => $horizontalNavigation,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

    /**
     * For each item in $targetNav:
     * find same id in $defaultNav and copy its children into target item.
     * NOTE: Your defaultNavigation top-level items do NOT have id ('dashboards' is inside children),
     * so this won't fill much unless you add matching ids.
     */
    private function _fill_children_from_default($targetNav, $defaultNav)
    {
        // Build map from default top-level by id
        $defaultMap = [];
        foreach ($defaultNav as $d) {
            if (isset($d['id'])) {
                $defaultMap[$d['id']] = $d;
            }
        }

        foreach ($targetNav as &$t) {
            if (isset($t['id']) && isset($defaultMap[$t['id']])) {
                $t['children'] = isset($defaultMap[$t['id']]['children']) ? $defaultMap[$t['id']]['children'] : [];
            }
        }
        unset($t);

        return $targetNav;
    }

    private function _sort_nav_by_no(&$items)
    {
        if (!is_array($items))
            return;

        // Sort current level
        usort($items, function ($a, $b) {
            $na = isset($a['no']) ? (int) $a['no'] : 999999;
            $nb = isset($b['no']) ? (int) $b['no'] : 999999;
            return $na <=> $nb;
        });

        // Sort children recursively
        foreach ($items as &$item) {
            if (isset($item['children']) && is_array($item['children'])) {
                $this->_sort_nav_by_no($item['children']);
            }
        }
        unset($item);
    }

}