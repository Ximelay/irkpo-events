<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $groupId;
    protected $importedCount = 0;
    protected $skippedCount = 0;
    protected $errors = [];

    public function __construct($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Получаем ФИО из разных возможных названий колонок
        $fullName = $this->getValue($row, ['фио', 'fio', 'ф.и.о', 'ф.и.о.', 'fullname', 'full_name', 'name']);

        // Пропускаем пустые строки
        if (empty($fullName)) {
            return null;
        }

        // Парсим ФИО
        $nameParts = $this->parseFullName($fullName);

        if (empty($nameParts['lastName']) || empty($nameParts['firstName'])) {
            $this->errors[] = "Строка с ФИО '{$fullName}' - не удалось распознать фамилию и имя";
            $this->skippedCount++;
            return null;
        }

        // Генерируем email если его нет (опционально)
        $email = $this->generateEmail($nameParts['lastName'], $nameParts['firstName']);

        // Проверяем, существует ли уже студент с похожими данными
        $existingUser = User::where('user_lastName', $nameParts['lastName'])
            ->where('user_firstName', $nameParts['firstName'])
            ->where('groups_groupID', $this->groupId)
            ->first();

        if ($existingUser) {
            $this->skippedCount++;
            return null;
        }

        $this->importedCount++;

        return new User([
            'user_firstName'  => $nameParts['firstName'],
            'user_lastName'   => $nameParts['lastName'],
            'user_middleName' => $nameParts['middleName'],
            'user_email'      => $email,
            'user_isActive'   => 1,
            'groups_groupID'  => $this->groupId,
        ]);
    }

    /**
     * Парсинг ФИО на составляющие
     */
    private function parseFullName($fullName)
    {
        // Убираем лишние пробелы
        $fullName = preg_replace('/\s+/', ' ', trim($fullName));

        // Разделяем по пробелам
        $parts = explode(' ', $fullName);

        $result = [
            'lastName' => '',
            'firstName' => '',
            'middleName' => null,
        ];

        // Обычно формат: Фамилия Имя Отчество
        if (count($parts) >= 1) {
            $result['lastName'] = $parts[0];
        }
        if (count($parts) >= 2) {
            $result['firstName'] = $parts[1];
        }
        if (count($parts) >= 3) {
            $result['middleName'] = $parts[2];
        }

        return $result;
    }

    /**
     * Генерация email на основе фамилии и имени
     */
    private function generateEmail($lastName, $firstName)
    {
        // Транслитерация для email
        $lastName = $this->transliterate($lastName);
        $firstName = $this->transliterate($firstName);

        $baseEmail = strtolower($lastName . '.' . substr($firstName, 0, 1));
        $email = $baseEmail . '@student.irkpo.ru';

        // Проверяем уникальность и добавляем номер если нужно
        $counter = 1;
        while (User::where('user_email', $email)->exists()) {
            $email = $baseEmail . $counter . '@student.irkpo.ru';
            $counter++;
        }

        return $email;
    }

    /**
     * Транслитерация русских букв в латиницу
     */
    private function transliterate($string)
    {
        $converter = [
            'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',
            'е' => 'e',   'ё' => 'e',   'ж' => 'zh',   'з' => 'z',   'и' => 'i',
            'й' => 'y',   'к' => 'k',   'л' => 'l',    'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',    'с' => 's',   'т' => 't',
            'у' => 'u',   'ф' => 'f',   'х' => 'h',    'ц' => 'c',   'ч' => 'ch',
            'ш' => 'sh',  'щ' => 'sch', 'ь' => '',     'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',
            'Е' => 'E',   'Ё' => 'E',   'Ж' => 'Zh',   'З' => 'Z',   'И' => 'I',
            'Й' => 'Y',   'К' => 'K',   'Л' => 'L',    'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',    'С' => 'S',   'Т' => 'T',
            'У' => 'U',   'Ф' => 'F',   'Х' => 'H',    'Ц' => 'C',   'Ч' => 'Ch',
            'Ш' => 'Sh',  'Щ' => 'Sch', 'Ь' => '',     'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        ];

        return strtr($string, $converter);
    }

    /**
     * Получить значение из массива по нескольким возможным ключам
     */
    private function getValue(array $row, array $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            $lowerKey = mb_strtolower($key);
            foreach ($row as $rowKey => $value) {
                if (mb_strtolower($rowKey) === $lowerKey && !empty($value)) {
                    return trim($value);
                }
            }
        }
        return null;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

