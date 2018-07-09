<?php

namespace Objects\AttendenceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EmployeeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmployeeRepository extends EntityRepository
{
    public function minusUserVacation($user_id, $casualDays, $unexpectedDays) {
        $query = "
                    UPDATE ObjectsAttendenceBundle:Employee e
                    SET e.casualVac = e.casualVac - :casualVac
                    , e.unexpectedVac = e.unexpectedVac - :unexpectedVac";

        $parameters = array("casualVac" => $casualDays, "unexpectedVac" => $unexpectedDays);

        if($user_id) {
            $query .= "WHERE e.user = :userId";
            $parameters["userId"] = $user_id;
        }

        return $this->getEntityManager()
                ->createQuery($query)
                ->setParameters($parameters)
                    ->getResult();
    }

    public function getEmployees() {
        return $this->getEntityManager()
                ->createQuery("
                    SELECT a
                    FROM ObjectsAttendenceBundle:Employee a
                    WHERE a.user = :user_id
                    AND a.checkin >= :startDate
                    AND a.checkout <= :endDate
                ")->getResult();
    }
}
