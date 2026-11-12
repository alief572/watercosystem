<?php
require_once dirname(__DIR__) . '/application/libraries/Stock_booking_rules.php';
$checks = 0;
function same($actual, $expected) { global $checks; ++$checks; if ($actual !== $expected) { throw new RuntimeException(json_encode(array($actual, $expected))); } }
function rejects($fn) { global $checks; ++$checks; try { $fn(); } catch (DomainException $e) { return; } throw new RuntimeException('Expected rejection'); }
same(Stock_booking_rules::reconcile(10, 0), array('qty'=>10, 'qty_book'=>0, 'qty_free'=>10));
same(Stock_booking_rules::reconcile(10, 3), array('qty'=>10, 'qty_book'=>3, 'qty_free'=>7));
same(Stock_booking_rules::release(10, 3, 7, 9), array('qty'=>10, 'qty_book'=>0, 'qty_free'=>10, 'released'=>3));
same(Stock_booking_rules::release(10, -2, 12, 4), array('qty'=>10, 'qty_book'=>0, 'qty_free'=>10, 'released'=>0));
same(Stock_booking_rules::release(10, 0, 10, 4), array('qty'=>10, 'qty_book'=>0, 'qty_free'=>10, 'released'=>0));
rejects(function(){ Stock_booking_rules::reconcile(-1, 0); });
rejects(function(){ Stock_booking_rules::reconcile(2, 3); });
rejects(function(){ Stock_booking_rules::quantity('1.5'); });
rejects(function(){ Stock_booking_rules::quantity('1 OR 1=1'); });
rejects(function(){ Stock_booking_rules::quantity(INF); });
rejects(function(){ Stock_booking_rules::quantity('9007199254740992'); });
echo "PASS: $checks stock booking rules\n";
