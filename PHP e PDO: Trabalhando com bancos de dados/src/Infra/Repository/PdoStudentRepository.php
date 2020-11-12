<?php

namespace Alura\Pdo\Infra\Repository;

use Alura\Pdo\Domain\Model\Phone;
use PDO;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $smtp = $this->connection->query('SELECT * FROM students');

        return $this->hydrateStudentsList($smtp);
    }

    public function studentsBirthAt(\DateTimeImmutable $birthDate): array
    {
        $smtp = $this->connection->query('SELECT * FROM students WHERE birth_date = ?;');
        $smtp->bindValue(1, $birthDate->format('Y-m-d'));
        $smtp->execute();

        return $this->hydrateStudentsList($smtp);
    }

    private function hydrateStudentsList(\PDOStatement $smtp): array
    {
        $students = $smtp->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($students as $student) {
            $result[] = new Student(
                 $student['id'],
                 $student['name'],
                new \DateTimeImmutable($student['birth_date'])
            );
        }

        return $result;
    }

    public function save(Student $student): bool
    {
        if ($student->id() == null) {
            return $this->insert($student);
        }
        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $smtp = $this->connection->prepare("INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);");

        $success = $smtp->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        $success ? $student->setId($this->connection->lastInsertId()) : null;

        return $success;
    }

    private function update(Student $student): bool
    {
        $smtp = $this->connection->prepare("UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;");
        $smtp->bindValue(':name', $student->name());
        $smtp->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $smtp->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $smtp->execute();
    }

    public function remove(Student $student): bool
    {
        $smtp = $this->connection->prepare("DELETE FROM students WHERE id = ?;");
        $smtp->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $smtp->execute();
    }

    public function studentsWithPhones(): array
    {
        $query = '
            SELECT 
                studensts.id,
                studensts.name,
                studensts.birth_date,
                phones.id AS phone_id,
                phones.area_code,
                phones.number
            FROM 
                studensts
                INNER JOIN phones ON phones.student_id = studensts.id
        ';
        $smtp = $this->connection->query($query);

        $studentsList = [];
        foreach ($smtp->fetchAll() as $row) {
            if (!array_key_exists($row['id'], $studentsList)) {
                $studentsList[$row['id']] = new Student($row['id'], $row['name'], new \DateTimeImmutable($row['birth_date']));
            }
            $studentsList[$row['id']]->addPhone(new Phone($row['phone_id'], $row['area_code'], $row['number']));
        }
        return $studentsList;
    }
}