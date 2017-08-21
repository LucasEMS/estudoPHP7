<?php


function buildLInkedList(array $primary,
        callable $makeLink)
{
    $linked = new ArrayIterator();
    foreach ($primary as $key => $row) {
        $linked->offsetSet($makeLink($row), $key);
    }
    $linked->ksort();
    return $linked;
}

/**
 * Produces an multi-dimensional array from CSV file
 *
 * @param string $fn = filename
 * @param array $headers = NULL upon input
 * @return array $result = [key => [id,xxx,yyy,zzz], key => [id,xxx,yyy,zzz]]
 */
function readCsv($fn, &$headers)
{
    if (!file_exists($fn)) {
        throw new Error('File Not Found');
    }
    $fileObj = new SplFileObject($fn, 'r');
    $result = array();
    $headers = array();
    $firstRow = TRUE;
    while ($row = $fileObj->fgetcsv()) {
        // store 1st row as headers
        if ($firstRow) {
            $firstRow = FALSE;
            $headers = $row;
        } else {
            if ($row && $row[0] !== NULL && $row[0] !== 0) {
                $result[$row[0]] = $row;
            }
        }
    }
    return $result;
}

function printHeaders($headers)
{
    return sprintf('%4s : %18s : %8s : %32s : %4s' . PHP_EOL,
                    ucfirst($headers[0]),
                    ucfirst($headers[1]),
                    ucfirst($headers[2]),
                    ucfirst($headers[3]),
                    ucfirst($headers[9]));
}


function printRow($row)
{
    return sprintf('%4d : %18s : %8.2f : %32s : %4s' . PHP_EOL,
                   $row[0], $row[1], $row[2], $row[3], $row[9]);
}

// produce output based on linked list
// NOTE: this is the real trick:
//       *don't* iterate through $customer directly!
//       instead, you iterate through the linked list
function printCustomer($headers, $linked, $customer)
{
    $output = '';
    $output .= printHeaders($headers);
    foreach ($linked as $key => $link) {
        // NOTE: use the link to access the appropriate $customer element
        $output .= printRow($customer[$link]);
    }
    return $output;
}