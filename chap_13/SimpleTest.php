<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/unit_test_simple.php';

class SimpleTest extends TestCase 
{
    // testXXX() methods go here
    public function testAdd()
    {
        $this->assertEquals(2, add(1, 1));
        $this->assertNotEquals(3, add(1, 1));
    }
    
    public function table(array $a)
    {
        $table = '<table>';
        foreach ($a as $row) {
            $table .= '<tr><td>';
            $table .= implode('</td><td>', $row);
            $table .= '</td><tr>';
        }
        $table .= '</table>';
        return $table;
    }
    
    public function testTable()
    {
        $a = [range('A', 'C'), range('D', 'F'), range('G', 'I')];
        $table = table($a);
        $this->assertRegExp('!^<table>.+</table>$!', $table);
        $this->assertRegExp('!<td>B</td>!', $table);
    }
}