<?php

namespace App\Imports;

use DateTime;

use App\Documents\Role;
use App\Documents\Team;
use App\Documents\User;
use App\Documents\Department;
use App\Documents\TeamMember;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;

use Maatwebsite\Excel\Concerns\ToCollection;

class TeamMembersImport implements ToCollection
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // Skip Header Row
            if ($index == 0) {
                continue;
            }

            $data = [

                'team_code' => trim($row[0]),

                'employee_email' => strtolower(trim($row[1])),

                'department_name' => trim($row[2]),

                'role_name' => trim($row[3]),

                'reporting_manager_email' => !empty($row[4])
                    ? strtolower(trim($row[4]))
                    : null,

                'is_active' => isset($row[5])
                    ? filter_var($row[5], FILTER_VALIDATE_BOOLEAN)
                    : true,
            ];

            // Row Validation
            $validator = Validator::make($data, [

                'team_code' => 'required|string',

                'employee_email' => 'required|email',

                'department_name' => 'required|string',

                'role_name' => 'required|string',

                'reporting_manager_email' => 'nullable|email',

                'is_active' => 'boolean'
            ]);

            // Skip Invalid Rows
            if ($validator->fails()) {
                continue;
            }

            // Team Lookup
            $team = $this->dm
                ->getRepository(Team::class)
                ->findOneBy([
                    'code' => strtoupper($data['team_code'])
                ]);

            if (!$team) {
                continue;
            }

            // Employee Lookup
            $user = $this->dm
                ->getRepository(User::class)
                ->findOneBy([
                    'email' => $data['employee_email']
                ]);

            if (!$user) {
                continue;
            }

            // Department Lookup
            $department = $this->dm
                ->getRepository(Department::class)
                ->findOneBy([
                    'name' => $data['department_name']
                ]);

            if (!$department) {
                continue;
            }

            // Role Lookup
            $role = $this->dm
                ->getRepository(Role::class)
                ->findOneBy([
                    'name' => $data['role_name']
                ]);

            if (!$role) {
                continue;
            }

            // Reporting Manager Lookup
            $reporting_manager = null;

            if (!empty($data['reporting_manager_email'])) {

                $reporting_manager = $this->dm
                    ->getRepository(User::class)
                    ->findOneBy([
                        'email' => $data['reporting_manager_email']
                    ]);
            }

            if (
                $reporting_manager &&
                $reporting_manager->getId() === $user->getId()
            ) {
                continue;
            }

            // Duplicate Check
            $exist = $this->dm
                ->getRepository(TeamMember::class)
                ->findOneBy([
                    'team' => $team,
                    'user' => $user,
                    'department' => $department
                ]);

            if ($exist) {
                continue;
            }

            // Create Team Member
            $team_member = new TeamMember();

            $team_member->setTeam($team);

            $team_member->setUser($user);

            $team_member->setDepartment($department);

            $team_member->setRole($role);

            $team_member->setReportingManager(
                $reporting_manager
            );

            $team_member->setIsActive(
                $data['is_active']
            );

            $team_member->setCreatedAt(
                new DateTime()
            );

            $this->dm->persist($team_member);
        }

        $this->dm->flush();
    }
}