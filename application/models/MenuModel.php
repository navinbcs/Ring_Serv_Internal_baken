<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu Model
 * 
 * Handles menu generation, permission checking, and filtering logic
 * based on user roles, tenant settings, and login type
 */
class MenuModel extends CI_Model
{
    private $cache = [];
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get login type for a tenant
     * Returns: 'TCare', 'Mudah', or 'Permai' (default)
     */
    public function getLoginType($tenantId)
    {
        // Since LoginType column doesn't exist in Tenants table,
        // we'll determine login type by checking tenant name or other criteria
        // For now, return 'Permai' (default) for all tenants
        
        // You can add custom logic here based on your requirements:
        // - Check tenant name
        // - Check a different column
        // - Look up in a different table
        
        return 'Permai';
        
        /* Alternative implementation if you have a way to identify TCare/Mudah tenants:
        $sql = "SELECT TenantName FROM Tenants WHERE TenantId = ?";
        $query = $this->db->query($sql, [$tenantId]);
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $tenantName = strtolower($row->TenantName);
            
            if (strpos($tenantName, 'tcare') !== false) {
                return 'TCare';
            } elseif (strpos($tenantName, 'mudah') !== false) {
                return 'Mudah';
            }
        }
        
        return 'Permai';
        */
    }

    /**
     * Get menu items for a user based on login type and permissions
     */
    public function getMenuItems($userId, $tenantId, $loginType)
    {
        // Get all available menu items
        $allMenuItems = $this->getAllMenuItems();
        
        // Get user permissions
        $userPermissions = $this->getUserPermissions($userId);
        
        // Filter by permissions
        $filteredItems = $this->filterByPermissions($allMenuItems, $userPermissions, $userId);
        
        // Apply login type specific filtering
        switch ($loginType) {
            case 'TCare':
                $filteredItems = $this->filterForTCare($filteredItems);
                break;
                
            case 'Mudah':
                $filteredItems = $this->filterForMudah($filteredItems);
                break;
                
            default: // Permai
                $filteredItems = $this->filterForPermai($filteredItems, $tenantId);
                break;
        }
        
        // Build hierarchy
        return $this->buildHierarchy($filteredItems);
    }

    /**
     * Get all available menu items (defined menu structure)
     */
    private function getAllMenuItems()
    {
        // This represents the menu structure from NavigationItems.cs
        return [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'url' => '/',
                'icon' => 'fa-pie-chart',
                'permission' => 'Dashboard:View',
                'order' => 1000,
                'parent' => null
            ],
            [
                'id' => 2,
                'title' => 'Registration',
                'url' => null,
                'icon' => 'fa-sign-in',
                'permission' => null,
                'order' => 2000,
                'parent' => null
            ],
            [
                'id' => 3,
                'title' => 'Appointment',
                'url' => '/Enrollment/Appointment',
                'icon' => 'fa-calendar',
                'permission' => 'Registration:Appointment:View',
                'order' => 2002,
                'parent' => 2
            ],
            [
                'id' => 4,
                'title' => 'Queue Management',
                'url' => '/Enrollment/Enrollment',
                'icon' => 'fa-pencil-square-o',
                'permission' => 'Registration:Enrollment:View',
                'order' => 2004,
                'parent' => 2
            ],
            [
                'id' => 5,
                'title' => 'Referrals & Services',
                'url' => null,
                'icon' => 'fa-exchange',
                'permission' => null,
                'order' => 3000,
                'parent' => null
            ],
            [
                'id' => 6,
                'title' => 'eReferrals Received (Mudah)',
                'url' => '/MudahEReferral/MudahEReferralReceived',
                'icon' => 'fa-exchange',
                'permission' => 'MudahEReferral:View',
                'order' => 3000,
                'parent' => 5,
                'loginType' => 'Mudah'
            ],
            [
                'id' => 7,
                'title' => 'eReferrals Sent (Mudah)',
                'url' => '/MudahEReferral/MudahReferralSent',
                'icon' => 'fa-exchange',
                'permission' => 'MudahEReferral:View',
                'order' => 3000,
                'parent' => 5,
                'loginType' => 'Mudah'
            ],
            [
                'id' => 8,
                'title' => 'MRDT',
                'url' => '/MudahEReferral/MudahEreferralMRDT',
                'icon' => 'fa-exchange',
                'permission' => 'MudahEReferral:View',
                'order' => 3000,
                'parent' => 5,
                'loginType' => 'Mudah'
            ],
            [
                'id' => 9,
                'title' => 'eReferrals Received (TCare)',
                'url' => '/TCareReferral/TCareEReferralReceived',
                'icon' => 'fa-exchange',
                'permission' => 'TCareEReferral:View',
                'order' => 3000,
                'parent' => 5,
                'loginType' => 'TCare'
            ],
            [
                'id' => 10,
                'title' => 'eReferrals Sent (TCare)',
                'url' => '/TCareReferral/TCareEReferralSent',
                'icon' => 'fa-exchange',
                'permission' => 'TCareEReferral:View',
                'order' => 3000,
                'parent' => 5,
                'loginType' => 'TCare'
            ],
            [
                'id' => 11,
                'title' => 'MR Digital Transfer',
                'url' => '/DigitalTransfer/DigitalTransfer',
                'icon' => 'fa-exchange',
                'permission' => 'DigitalTransfer:View',
                'order' => 3000,
                'parent' => 5
            ],
            [
                'id' => 12,
                'title' => 'Clinical Management',
                'url' => null,
                'icon' => 'fa-stethoscope',
                'permission' => null,
                'order' => 4000,
                'parent' => null
            ],
            [
                'id' => 13,
                'title' => 'My Queue',
                'url' => '/Clinical/OutPatient',
                'icon' => 'fa-users',
                'permission' => 'OutPatient:View',
                'order' => 4002,
                'parent' => 12
            ],
            [
                'id' => 14,
                'title' => 'Administration',
                'url' => null,
                'icon' => 'fa-cog',
                'permission' => null,
                'order' => 5000,
                'parent' => null
            ],
            [
                'id' => 15,
                'title' => 'Facility Management',
                'url' => null,
                'icon' => null,
                'permission' => null,
                'order' => 5999,
                'parent' => 14
            ],
            [
                'id' => 16,
                'title' => 'Ring Group Master',
                'url' => '/Administration/RingGroupMaster',
                'icon' => 'fa-star',
                'permission' => 'Administration:RingGroupMaster:View',
                'order' => 5999,
                'parent' => 15
            ],
            [
                'id' => 17,
                'title' => 'Facilities',
                'url' => '/Administration/Tenant',
                'icon' => 'fa-star',
                'permission' => 'Administration:Tenant:View',
                'order' => 6002,
                'parent' => 15
            ],
            [
                'id' => 18,
                'title' => 'Service Master',
                'url' => '/Administration/ServiceMaster',
                'icon' => 'fa-star',
                'permission' => 'Administration:ServiceMaster:View',
                'order' => 6002,
                'parent' => 15
            ],
            [
                'id' => 19,
                'title' => 'Item Master',
                'url' => '/Administration/ItemMaster',
                'icon' => 'fa-star',
                'permission' => 'Administration:ItemMaster:View',
                'order' => 6005,
                'parent' => 15
            ],
            [
                'id' => 20,
                'title' => 'Department Master',
                'url' => '/Administration/DepartmentMaster',
                'icon' => 'fa-star',
                'permission' => 'Administration:DepartmentMaster:View',
                'order' => 6006,
                'parent' => 15
            ],
            [
                'id' => 21,
                'title' => 'User Management',
                'url' => null,
                'icon' => null,
                'permission' => null,
                'order' => 6003,
                'parent' => 14
            ],
            [
                'id' => 22,
                'title' => 'Roles',
                'url' => '/Administration/Role',
                'icon' => 'fa-lock',
                'permission' => 'UserManagement:Roles:View',
                'order' => 6003,
                'parent' => 21
            ],
            [
                'id' => 23,
                'title' => 'Users',
                'url' => '/Administration/User',
                'icon' => 'fa-users',
                'permission' => 'UserManagement:User:View',
                'order' => 6004,
                'parent' => 21
            ],
            [
                'id' => 24,
                'title' => 'TCare Users',
                'url' => '/Administration/TCareUsers',
                'icon' => 'fa-users',
                'permission' => 'Administration:TCareUsers:View',
                'order' => 6004,
                'parent' => 21,
                'loginType' => 'TCare'
            ],
            [
                'id' => 25,
                'title' => 'Billing',
                'url' => '/Billing/ChargeEntryHeader',
                'icon' => 'fa-money',
                'permission' => 'Billing:View',
                'order' => 7000,
                'parent' => null
            ],
            [
                'id' => 26,
                'title' => 'Premium Services',
                'url' => '/PremiumServices/PremiumServicesMaster',
                'icon' => 'fa-star',
                'permission' => 'PremiumServices:View',
                'order' => 7000,
                'parent' => null,
                'requiresPremium' => true
            ]
        ];
    }

    /**
     * Get all permissions for a user (both direct and from roles)
     */
    public function getUserPermissions($userId)
    {
        $cacheKey = "user_permissions_{$userId}";
        
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $permissions = [];

        // Admin user has all permissions
        $sql = "SELECT Username FROM Users WHERE UserId = ?";
        $query = $this->db->query($sql, [$userId]);
        if ($query->num_rows() > 0 && $query->row()->Username === 'admin') {
            $this->cache[$cacheKey] = ['*']; // Wildcard for admin
            return ['*'];
        }

        // Get direct user permissions
        $sql = "SELECT PermissionKey, Granted 
                FROM UserPermissions 
                WHERE UserId = ?";
        $query = $this->db->query($sql, [$userId]);
        
        foreach ($query->result() as $row) {
            if ($row->Granted) {
                $permissions[] = $row->PermissionKey;
            }
        }

        // Get role-based permissions
        $sql = "SELECT rp.PermissionKey 
                FROM UserRoles ur
                INNER JOIN RolePermissions rp ON ur.RoleId = rp.RoleId
                WHERE ur.UserId = ?";
        $query = $this->db->query($sql, [$userId]);
        
        foreach ($query->result() as $row) {
            $permissions[] = $row->PermissionKey;
        }

        $permissions = array_unique($permissions);
        $this->cache[$cacheKey] = $permissions;
        
        return $permissions;
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($userId, $permissionKey)
    {
        $userPermissions = $this->getUserPermissions($userId);
        
        // Admin has all permissions
        if (in_array('*', $userPermissions)) {
            return true;
        }
        
        // Check exact match
        if (in_array($permissionKey, $userPermissions)) {
            return true;
        }
        
        // Check for implicit permissions (e.g., Modify implies View)
        $implicitPermissions = $this->getImplicitPermissions($permissionKey);
        foreach ($implicitPermissions as $implicit) {
            if (in_array($implicit, $userPermissions)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get implicit permissions (e.g., if user has Modify, they implicitly have View)
     */
    private function getImplicitPermissions($permissionKey)
    {
        // Extract base permission and action
        $parts = explode(':', $permissionKey);
        
        if (count($parts) < 2) {
            return [];
        }
        
        $action = end($parts);
        
        // If checking for View, both Modify and Delete imply View
        if ($action === 'View') {
            $baseParts = array_slice($parts, 0, -1);
            return [
                implode(':', array_merge($baseParts, ['Modify'])),
                implode(':', array_merge($baseParts, ['Delete']))
            ];
        }
        
        return [];
    }

    /**
     * Filter menu items by user permissions
     */
    private function filterByPermissions($menuItems, $userPermissions, $userId)
    {
        // Admin sees everything
        if (in_array('*', $userPermissions)) {
            return $menuItems;
        }

        $filtered = [];
        
        foreach ($menuItems as $item) {
            // If no permission required, include it
            if (empty($item['permission'])) {
                $filtered[] = $item;
                continue;
            }
            
            // Check if user has this permission
            if ($this->hasPermission($userId, $item['permission'])) {
                $filtered[] = $item;
            }
        }
        
        return $filtered;
    }

    /**
     * Filter menu items for TCare login type
     */
    private function filterForTCare($menuItems)
    {
        $allowedUrls = [
            '/',
            '/TCareReferral/TCareEReferralSent',
            '/TCareReferral/TCareEReferralReceived',
            '/TCareReferral/TCareReferralSentView',
            '/Administration/TCareUsers',
            '/Administration/ServiceMaster'
        ];

        return array_filter($menuItems, function($item) use ($allowedUrls) {
            return in_array($item['url'], $allowedUrls) || 
                   (isset($item['loginType']) && $item['loginType'] === 'TCare');
        });
    }

    /**
     * Filter menu items for Mudah login type
     */
    private function filterForMudah($menuItems)
    {
        $allowedUrls = [
            '/',
            '/MudahEReferral/MudahEreferralMRDT',
            '/MudahEReferral/MudahEReferralReceived',
            '/MudahEReferral/MudahReferralSent',
            '/Administration/MudahUsers',
            '/Administration/ServiceMaster'
        ];

        return array_filter($menuItems, function($item) use ($allowedUrls) {
            return in_array($item['url'], $allowedUrls) || 
                   (isset($item['loginType']) && $item['loginType'] === 'Mudah');
        });
    }

    /**
     * Filter menu items for Permai login type (default)
     */
    private function filterForPermai($menuItems, $tenantId)
    {
        // Remove TCare and Mudah specific items
        $filtered = array_filter($menuItems, function($item) {
            $tcareUrls = [
                '/TCareReferral/TCareEReferralSent',
                '/TCareReferral/TCareEReferralReceived',
                '/Administration/TCareUsers'
            ];
            
            $mudahUrls = [
                '/MudahEReferral/MudahEreferralMRDT',
                '/MudahEReferral/MudahEReferralReceived',
                '/MudahEReferral/MudahReferralSent',
                '/Administration/ServiceMaster'
            ];
            
            return !in_array($item['url'], array_merge($tcareUrls, $mudahUrls));
        });

        // Check if Premium Service is enabled (with error handling)
        $isPremiumService = false;
        try {
            $sql = "SELECT IsPremiumService FROM Tenants WHERE TenantId = ?";
            $query = $this->db->query($sql, [$tenantId]);
            
            if ($query && $query->num_rows() > 0) {
                $isPremiumService = (bool)$query->row()->IsPremiumService;
            }
        } catch (Exception $e) {
            error_log("Error checking IsPremiumService: " . $e->getMessage());
            // Continue with default value
        }

        // If not premium, check referral status (with error handling)
        if (!$isPremiumService) {
            try {
                $sql = "SELECT RM.IsReferralActive 
                        FROM RingGroupMaster RM 
                        INNER JOIN RingGroupTenants TT ON TT.RingGroupId = RM.RingGroupMasterId 
                        WHERE TT.TenantId = ?";
                $query = $this->db->query($sql, [$tenantId]);
                
                $isReferralActive = true; // Default to true
                if ($query && $query->num_rows() > 0) {
                    $isReferralActive = (bool)$query->row()->IsReferralActive;
                }

                // Remove referral menu if not active
                if (!$isReferralActive) {
                    $filtered = array_filter($filtered, function($item) {
                        return $item['url'] !== '/Referral/Referral';
                    });
                }
            } catch (Exception $e) {
                error_log("Error checking IsReferralActive: " . $e->getMessage());
                // Continue without filtering
            }
        }

        // Remove premium services menu if not premium
        if (!$isPremiumService) {
            $filtered = array_filter($filtered, function($item) {
                return !isset($item['requiresPremium']) || !$item['requiresPremium'];
            });
        }

        return array_values($filtered);
    }

    /**
     * Build hierarchical menu structure
     */
    private function buildHierarchy($flatItems)
    {
        $hierarchy = [];
        $lookup = [];

        // Sort by order
        usort($flatItems, function($a, $b) {
            return $a['order'] - $b['order'];
        });

        // First pass: create lookup and add items
        foreach ($flatItems as $item) {
            $item['children'] = [];
            $lookup[$item['id']] = $item;
        }

        // Second pass: build parent-child relationships
        foreach ($lookup as $id => $item) {
            if ($item['parent'] === null) {
                $hierarchy[] = &$lookup[$id];
            } else {
                if (isset($lookup[$item['parent']])) {
                    $lookup[$item['parent']]['children'][] = &$lookup[$id];
                }
            }
        }

        // Third pass: remove empty parent nodes
        $this->removeEmptyParents($hierarchy);

        return $hierarchy;
    }

    /**
     * Remove parent menu items that have no children
     */
    private function removeEmptyParents(&$items)
    {
        for ($i = count($items) - 1; $i >= 0; $i--) {
            $item = &$items[$i];
            
            if (!empty($item['children'])) {
                $this->removeEmptyParents($item['children']);
            }
            
            // Remove if it's a parent with no URL and no children
            if ($item['url'] === null && empty($item['children'])) {
                array_splice($items, $i, 1);
            }
        }
    }

    /**
     * Get active path for current URL
     */
    public function getActivePath($menuItems, $currentUrl)
    {
        $activePath = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
        $this->searchActivePath($menuItems, $currentUrl, $activePath, 0);
        return $activePath;
    }

    /**
     * Recursively search for active menu item
     */
    private function searchActivePath($items, $currentUrl, &$activePath, $depth)
    {
        foreach ($items as $index => $item) {
            if (isset($item['url']) && 
                rtrim($item['url'], '/') === rtrim($currentUrl, '/')) {
                $activePath[$depth] = $index;
                return true;
            }
            
            if (!empty($item['children'])) {
                $activePath[$depth] = $index;
                if ($this->searchActivePath($item['children'], $currentUrl, $activePath, $depth + 1)) {
                    return true;
                }
                $activePath[$depth] = -1;
            }
        }
        
        return false;
    }
}
