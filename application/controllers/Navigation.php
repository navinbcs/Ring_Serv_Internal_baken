<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Navigation Controller (CI3)
 * GET /api/common/navigation
 *
 * Role-based navigation (mapped to your RoleName table)
 * - MASTER (Super Administrator, RING Administrator)
 * - FRONTDESK_NURSE (Front Desk, Appointment/Registration Clerk, Nurse roles, etc.)
 * - DOCTOR (Doctor, Radiologist, CONVERGE DOCTORS)
 * - FACILITY_ADMIN (Facility Administrator)
 * - GROUP_ADMIN (Group Admin)
 * - LIMITED (fallback)
 */
class Navigation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // If you need helpers/libraries, load here
        // $this->load->helper('url');
    }

    /**
     * GET /api/common/navigation
     */
    public function index()
    {
        // -----------------------------
        // Preflight
        // -----------------------------
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(["status" => "ok"]));
        }

        // -----------------------------
        // Read JWT
        // -----------------------------
        $auth = $this->input->get_request_header('Authorization', true);
        if (!$auth) {
            $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        }

        if (!$auth || stripos($auth, 'Bearer ') !== 0) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(401)
                ->set_output(json_encode([
                    "status" => "error",
                    "message" => "Missing/invalid Authorization header"
                ]));
        }

        $token = trim(str_ireplace('Bearer', '', $auth));

        try {
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
        } catch (Exception $e) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(401)
                ->set_output(json_encode([
                    "status" => "error",
                    "message" => "Invalid token",
                    "detail" => $e->getMessage()
                ]));
        }

        // -----------------------------
        // Role mapping using your RoleName table
        // -----------------------------
        $rawRole = trim((string)($tokenData->Role ?? ''));
        $role    = strtolower($rawRole);

        $masterRoles = [
            'super administrator',
            'ring administrator',
        ];

        $frontDeskNurseRoles = [
            'front desk',
            'appointment clerk',
            'registration clerk',
            'nurse',
            'assistant nurse',
            'charge nurse',
            'nursing supervisor',
            'chief of nursing services',
            'medical record assistant',
            'medical record executive',
            'cashier', // OPTIONAL: keep if cashier should see billing/dispense
        ];

        $doctorRoles = [
            'doctor',
            'radiologist',
            'converge doctors',
        ];

        $facilityAdminRoles = [
            'facility administrator',
        ];

        $groupAdminRoles = [
            'group admin',
        ];

        // OPTIONAL: If Pharmacist should also see Dispense, add them here:
        $pharmacyRoles = [
            'pharmacist',
            'senior pharmacist',
        ];

        if (in_array($role, $masterRoles, true)) {
            $menuBucket = 'MASTER';
        } elseif (in_array($role, $groupAdminRoles, true)) {
            $menuBucket = 'GROUP_ADMIN';
        } elseif (in_array($role, $facilityAdminRoles, true)) {
            $menuBucket = 'FACILITY_ADMIN';
        } elseif (in_array($role, $doctorRoles, true)) {
            $menuBucket = 'DOCTOR';
        } elseif (in_array($role, $frontDeskNurseRoles, true)) {
            $menuBucket = 'FRONTDESK_NURSE';
        } elseif (in_array($role, $pharmacyRoles, true)) {
            // If you want pharmacists to have similar access as front desk/nurse for Dispense
            $menuBucket = 'PHARMACY';
        } else {
            $menuBucket = 'LIMITED';
        }

        // -----------------------------
        // Build navigation
        // -----------------------------
        $defaultNavigation = $this->_build_default_navigation_by_bucket($menuBucket);

        // Sort default nav group children
        if (isset($defaultNavigation[0]['children'])) {
            $this->_sort_nav_by_no($defaultNavigation[0]['children']);
        }

        // Keep payload structure expected by Fuse
        $payload = [
            'compact'    => $this->_empty_aside(),
            'default'    => $defaultNavigation,
            'futuristic' => $this->_empty_futuristic(),
            'horizontal' => $this->_empty_horizontal(),
        ];

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Build navigation by bucket
     */
    private function _build_default_navigation_by_bucket($bucket)
    {
        $nav = [[
            'type' => 'group',
            'icon' => 'heroicons_solid:home',
            'children' => [],
        ]];

        // -----------------------------
        // Dashboard
        // -----------------------------
        if (in_array($bucket, ['MASTER','DOCTOR','FACILITY_ADMIN','GROUP_ADMIN'], true)) {

            $dashChildren = [];

            if ($bucket === 'MASTER') {
                $dashChildren[] = [
                    'title' => "Doctor's Dashboard",
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:user',
                    'link'  => '/dashboards/drdashboard',
                ];
                $dashChildren[] = [
                    'title' => 'Facility Admin Dashboard',
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:building-office-2',
                    'link'  => '/dashboards/facilityadmindashboard',
                ];
                $dashChildren[] = [
                    'title' => 'Group Admin Dashboard',
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:users',
                    'link'  => '/dashboards/groupadmindashboard',
                ];
            }

            if ($bucket === 'DOCTOR') {
                $dashChildren[] = [
                    'title' => "Doctor's Dashboard",
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:user',
                    'link'  => '/dashboards/drdashboard',
                ];
            }

            if ($bucket === 'FACILITY_ADMIN') {
                $dashChildren[] = [
                    'title' => 'Facility Admin Dashboard',
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:building-office-2',
                    'link'  => '/dashboards/facilityadmindashboard',
                ];
            }

            if ($bucket === 'GROUP_ADMIN') {
                $dashChildren[] = [
                    'title' => 'Facility Admin Dashboard',
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:building-office-2',
                    'link'  => '/dashboards/facilityadmindashboard',
                ];
                $dashChildren[] = [
                    'title' => 'Group Admin Dashboard',
                    'type'  => 'basic',
                    'icon'  => 'heroicons_solid:users',
                    'link'  => '/dashboards/groupadmindashboard',
                ];
            }

            $nav[0]['children'][] = [
                'no'    => 1,
                'id'    => 'dashboard',
                'title' => 'Dashboard',
                'type'  => 'collapsable',
                'icon'  => 'heroicons_solid:chart-pie',
                'children' => $dashChildren,
            ];
        }

        // -----------------------------
        // Registration (MASTER + DOCTOR + FRONTDESK_NURSE)
        // -----------------------------
        if (in_array($bucket, ['MASTER','DOCTOR','FRONTDESK_NURSE'], true)) {
            $nav[0]['children'][] = [
                'no' => 2,
                'id' => 'registration',
                'title' => 'Registration',
                'type'  => 'collapsable',
                'icon'  => 'mat_solid:login',
                'children' => [
                    [
                        'title' => 'Calendar',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:calendar',
                        'link'  => '/doctor-appointment',
                    ],
                    [
                        'title' => 'Appointment',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:calendar',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Enrollment/Appointment',
                    ],
                    [
                        'title' => 'Queue Management',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:pencil-square',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Enrollment/Enrollment',
                    ],
                ],
            ];
        }

        // -----------------------------
        // Clinical Management (MASTER + DOCTOR)
        // -----------------------------
        if (in_array($bucket, ['MASTER','DOCTOR'], true)) {
            $nav[0]['children'][] = [
                'no' => 3,
                'id' => 'clinical-management',
                'title' => 'Clinical Management',
                'type'  => 'collapsable',
                'icon'  => 'heroicons_solid:clipboard-document-check',
                'children' => [
                    [
                        'title' => 'My Queue',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:user-group',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Clinical/OutPatient',
                    ],
                    [
                        'title' => 'Clinic Queue',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:building-office',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Clinical/OutPatient',
                    ],
                ],
            ];
        }

        // -----------------------------
        // Dispense (MASTER + FRONTDESK_NURSE + PHARMACY)
        // -----------------------------
        if (in_array($bucket, ['MASTER','FRONTDESK_NURSE','PHARMACY'], true)) {
            $nav[0]['children'][] = [
                'no' => 4,
                'id' => 'dispense',
                'title' => 'Dispense',
                'type'  => 'basic',
                'icon'  => 'mat_solid:local_pharmacy',
                'externalLink' => true,
                'link'  => 'https://internal.ring.healthcare/Billing/Pharmacy',
            ];
        }

        // -----------------------------
        // Billing (MASTER + FRONTDESK_NURSE)
        // -----------------------------
        if (in_array($bucket, ['MASTER','FRONTDESK_NURSE'], true)) {
            $nav[0]['children'][] = [
                'no' => 5,
                'id' => 'billing',
                'title' => 'Billing',
                'type'  => 'collapsable',
                'icon'  => 'mat_solid:receipt_long',
                'children' => [
                    [
                        'title' => 'Charges & Bill',
                        'type'  => 'basic',
                        'icon'  => 'mat_solid:request_quote',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Billing/ChargeEntryHeader',
                    ],
                    [
                        'title' => 'Purchase Package',
                        'type'  => 'basic',
                        'icon'  => 'mat_solid:fact_check',
                         'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Billing/PackagePurchase#!1',
                    ],
                ],
            ];
        }

        // -----------------------------
        // MR Digital Transfer (MASTER + DOCTOR + FRONTDESK_NURSE)
        // -----------------------------
        if (in_array($bucket, ['MASTER','DOCTOR','FRONTDESK_NURSE'], true)) {
            $nav[0]['children'][] = [
                'no' => 6,
                'id' => 'mr-digital-transfer',
                'title' => 'MR Digital Transfer',
                'type'  => 'basic',
                'icon'  => 'heroicons_solid:arrow-path-rounded-square',
                'externalLink' => true,
                'link'  => 'https://internal.ring.healthcare/DigitalTransfer/DigitalTransfer',
            ];
        }

        // -----------------------------
        // eReferrals (MASTER + DOCTOR)
        // -----------------------------
        if (in_array($bucket, ['MASTER','DOCTOR'], true)) {
            $nav[0]['children'][] = [
                'no' => 7,
                'id' => 'ereferrals',
                'title' => 'eReferrals',
                'type'  => 'collapsable',
                'icon'  => 'heroicons_solid:arrow-trending-up',
                'children' => [
                    [
                        'title' => 'eReferrals Received',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:inbox-arrow-down',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/Referral/Referral',
                    ],
                    [
                        'title' => 'eReferrals Sent',
                        'type'  => 'basic',
                        'icon'  => 'heroicons_solid:paper-airplane',
                        'externalLink' => true,
                        'link'  => 'https://internal.ring.healthcare/DigitalTransfer/EReferralStatus',
                    ],
                ],
            ];
        }

        // -----------------------------
        // Administration (varies by bucket)
        // -----------------------------
        $facilityMgmt = [];
        $userMgmt     = [];

        if ($bucket === 'MASTER') {
            $facilityMgmt = [
                $this->_ext('Ring Group Master', 'mat_solid:groups', 'https://internal.ring.healthcare/Administration/RingGroupMaster'),
                $this->_ext('Patient Master', 'mat_solid:person_search', 'https://internal.ring.healthcare/Administration/PatientMaster'),
                $this->_ext('Service Master', 'mat_solid:star', 'https://internal.ring.healthcare/Administration/ServiceMaster'),
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
                $this->_ext('Department Master', 'mat_solid:account_tree', 'https://internal.ring.healthcare/Administration/DepartmentMaster'),
                $this->_int('Package Master', 'mat_solid:fact_check', 'package/list'),
                $this->_int('Inventory', 'mat_solid:inventory_2', 'inventory/item-stock'),
            ];
            $userMgmt = [
                $this->_ext('Users', 'mat_solid:person', 'https://internal.ring.healthcare/Administration/User'),
                $this->_ext('User Roles', 'mat_solid:admin_panel_settings', 'https://internal.ring.healthcare/Administration/Role'),
            ];
        }

        if ($bucket === 'FRONTDESK_NURSE') {
            $facilityMgmt = [
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
                $this->_int('Package Master', 'mat_solid:fact_check', 'package/list'),
                $this->_int('Inventory', 'mat_solid:inventory_2', 'inventory/item-stock'),
            ];
            $userMgmt = [
                $this->_ext('Users', 'mat_solid:person', 'https://internal.ring.healthcare/Administration/User'),
            ];
        }

        if ($bucket === 'DOCTOR') {
            $facilityMgmt = [
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
            ];
            $userMgmt = [
                $this->_ext('Users', 'mat_solid:person', 'https://internal.ring.healthcare/Administration/User'),
            ];
        }

        if ($bucket === 'FACILITY_ADMIN') {
            $facilityMgmt = [
                $this->_ext('Department Master', 'mat_solid:account_tree', 'https://internal.ring.healthcare/Administration/DepartmentMaster'),
                $this->_ext('Service Master', 'mat_solid:star', 'https://internal.ring.healthcare/Administration/ServiceMaster'),
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
                $this->_int('Package Master', 'mat_solid:fact_check', 'package/list'),
                $this->_int('Inventory', 'mat_solid:inventory_2', 'inventory/item-stock'),
            ];
            $userMgmt = [
                $this->_ext('Users', 'mat_solid:person', 'https://internal.ring.healthcare/Administration/User'),
            ];
        }

        if ($bucket === 'GROUP_ADMIN') {
            $facilityMgmt = [
                $this->_ext('Facilities', 'mat_solid:domain', 'https://internal.ring.healthcare/Administration/Tenant'),
                $this->_ext('Department Master', 'mat_solid:account_tree', 'https://internal.ring.healthcare/Administration/DepartmentMaster'),
                $this->_ext('Service Master', 'mat_solid:star', 'https://internal.ring.healthcare/Administration/ServiceMaster'),
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
                $this->_int('Package Master', 'mat_solid:fact_check', 'package/list'),
                $this->_int('Inventory', 'mat_solid:inventory_2', 'inventory/item-stock'),
            ];
            $userMgmt = [
                $this->_ext('Users', 'mat_solid:person', 'https://internal.ring.healthcare/Administration/User'),
            ];
        }

        if ($bucket === 'PHARMACY') {
            // Pharmacy users: only Dispense + basic admin links (optional)
            $facilityMgmt = [
                $this->_ext('Item Master', 'mat_solid:inventory_2', 'https://internal.ring.healthcare/Administration/ItemMaster'),
            ];
        }

        if (!empty($facilityMgmt) || !empty($userMgmt)) {
            $children = [];

            if (!empty($facilityMgmt)) {
                $children[] = [
                    'title' => 'Facility Management',
                    'type'  => 'collapsable',
                    'icon'  => 'mat_solid:calendar_view_day',
                    'children' => $facilityMgmt,
                ];
            }

            if (!empty($userMgmt)) {
                $children[] = [
                    'title' => 'User Management',
                    'type'  => 'collapsable',
                    'icon'  => 'mat_solid:manage_accounts',
                    'children' => $userMgmt,
                ];
            }

            $nav[0]['children'][] = [
                'no' => 8,
                'id' => 'administration',
                'title' => 'Administration',
                'type'  => 'collapsable',
                'icon'  => 'heroicons_solid:cog-6-tooth',
                'children' => $children,
            ];
        }

        // LIMITED: show nothing or just dashboard? (currently nothing)
        if ($bucket === 'LIMITED') {
            // If you want a minimal dashboard:
            // $nav[0]['children'][] = [
            //     'no'=>1,'id'=>'dashboard','title'=>'Dashboard','type'=>'basic','icon'=>'heroicons_solid:chart-pie','link'=>'/dashboards/drdashboard'
            // ];
        }

        return $nav;
    }

    // -----------------------------
    // Helpers
    // -----------------------------
    private function _ext($title, $icon, $url)
    {
        return [
            'title' => $title,
            'type'  => 'basic',
            'icon'  => $icon,
            'externalLink' => true,
            'link'  => $url,
        ];
    }

    private function _int($title, $icon, $route)
    {
        return [
            'title' => $title,
            'type'  => 'basic',
            'icon'  => $icon,
            'link'  => $route,
        ];
    }

    private function _sort_nav_by_no(&$items)
    {
        if (!is_array($items)) return;

        usort($items, function ($a, $b) {
            $na = isset($a['no']) ? (int)$a['no'] : 999999;
            $nb = isset($b['no']) ? (int)$b['no'] : 999999;
            return $na <=> $nb;
        });

        foreach ($items as &$item) {
            if (isset($item['children']) && is_array($item['children'])) {
                $this->_sort_nav_by_no($item['children']);
            }
        }
        unset($item);
    }

    private function _empty_aside()
    {
        return [
            ['id' => 'dashboards', 'title' => 'Dashboards', 'type' => 'aside', 'icon' => 'heroicons_solid:home', 'children' => []],
            ['id' => 'apps', 'title' => 'Apps', 'type' => 'aside', 'icon' => 'heroicons_solid:squares-2x2', 'children' => []],
            ['id' => 'pages', 'title' => 'Pages', 'type' => 'aside', 'icon' => 'heroicons_solid:document-duplicate', 'children' => []],
        ];
    }

    private function _empty_futuristic()
    {
        return [
            ['id' => 'dashboards', 'title' => 'DASHBOARDS', 'type' => 'group', 'children' => []],
            ['id' => 'apps', 'title' => 'APPS', 'type' => 'group', 'children' => []],
        ];
    }

    private function _empty_horizontal()
    {
        return [];
    }
}
