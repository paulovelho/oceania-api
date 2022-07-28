<?php

	include_once("_mockDatabase.php");

	class TestOfBulkTasks extends UnitTestCase {

		private $api;
		private $mockDb;

		function setUp() {
			$this->api = new TasksApi();
			$this->mockDb = new MagratheaDatabaseMock();
			MagratheaDatabase::Instance()->Mock($this->mockDb);
		}
		function tearDown() { }
		function _getTests(){
			return array("testShouldAddSubTasks");
		}

		function testShouldGetHours() {
			$this->mockDb->setReturns([75, 76, 77, 78, 79]);

			$content = "some task with hours - 5";
			$response = $this->api->manageBulk(42, $content);
			$this->assertEqual(count($response), 1);
			$task = $response[0];
			$this->assertEqual($task->id, 75);
			$this->assertEqual($task->task, "some task with hours");
			$this->assertEqual($task->hours_estimation, 5);

			$content = "some task with dash - and with hours - 3";
			$response = $this->api->manageBulk(42, $content);
			$this->assertEqual(count($response), 1);
			$task = $response[0];
			$this->assertEqual($task->id, 76);
			$this->assertEqual($task->task, "some task with dash - and with hours");
			$this->assertEqual($task->hours_estimation, 3);

			$content = "some task - without hours - five";
			$response = $this->api->manageBulk(42, $content);
			$this->assertEqual(count($response), 1);
			$task = $response[0];
			$this->assertEqual($task->id, 77);
			$this->assertEqual($task->project_id, 42);
			$this->assertEqual($task->task, "some task - without hours - five");
			$this->assertEqual($task->hours_estimation, 8);

			$content = "look how this -dash- is - annoying-4";
			$response = $this->api->manageBulk(42, $content);
			$task = $response[0];
			$this->assertEqual($task->task, "look how this -dash- is - annoying");
			$this->assertEqual($task->hours_estimation, 4);

			$content = "why did you add this h at the end? - 2h";
			$response = $this->api->lineToTask($content);
			$this->assertEqual($response['name'], "why did you add this h at the end?");
			$this->assertEqual($response['hours'], 2);
		}

		function testShouldInsertMultipleTasks() {
			$this->mockDb->setReturns([20, 21]);

			$content = "task 1 - 5\n task two with no hours";
			$response = $this->api->manageBulk(23, $content);
			$this->assertEqual(count($response), 2);
			$t1 = $response[0];
			$this->assertEqual($t1->id, 20);
			$this->assertEqual($t1->project_id, 23);
			$this->assertEqual($t1->task, "task two with no hours");
			$this->assertEqual($t1->hours_estimation, 8);
			$t2 = $response[1];
			$this->assertEqual($t2->id, 21);
			$this->assertEqual($t2->project_id, 23);
			$this->assertEqual($t2->task, "task 1");
			$this->assertEqual($t2->hours_estimation, 5);
		}

		function testShouldParseSubTasks() {
			$t1 = $this->api->lineToTask("this is a simple task - 1H");
			$this->assertEqual($t1['name'], "this is a simple task");
			$this->assertEqual($t1['hours'], 1);
			$this->assertEqual($t1['depth'], 0);

			$t2 = $this->api->lineToTask("- this is a subtask - 4");
			$this->assertEqual($t2['name'], "this is a subtask");
			$this->assertEqual($t2['hours'], 4);
			$this->assertEqual($t2['depth'], 1);

			$t3 = $this->api->lineToTask("-- this is a sub-subtask");
			$this->assertEqual($t3['name'], "this is a sub-subtask");
			$this->assertEqual($t3['hours'], null);
			$this->assertEqual($t3['depth'], 2);

			$t4 = $this->api->lineToTask("- -- - this is a sub - sub-subtask - 45");
			$this->assertEqual($t4['name'], "this is a sub - sub-subtask");
			$this->assertEqual($t4['hours'], 45);
			$this->assertEqual($t4['depth'], 4);
		}

		function testShouldAddSubTasks() {
			$this->mockDb->setReturns([12, 13, 14]);

			$content = "this is the main task\n- this is a subtask - 3\n-this is another subtask - 2";
			$response = $this->api->manageBulk(7, $content);
			$this->assertEqual(count($response), 3);
			$t1 = $response[0];
			$this->assertEqual($t1->id, 12);
			$this->assertEqual($t1->task, "this is another subtask");
			$this->assertEqual($t1->hours_estimation, 2);
			$t2 = $response[1];
			$this->assertEqual($t2->id, 13);
			$this->assertEqual($t2->task, "this is a subtask");
			$this->assertEqual($t2->hours_estimation, 3);
			$t3 = $response[2];
			$this->assertEqual($t3->id, 14);
			$this->assertEqual($t3->task, "this is the main task");
			$this->assertEqual($t3->hours_estimation, 5);
			$this->assertEqual($t3->depends_on, [12, 13]);
		}

		function testShouldAddTaskWithActivity() {
			$this->mockDb->setReturns([ 2 ]);

			$rs = $this->api->manageBulk(7, "some activity", 5); // 5 = development
			$this->assertEqual(count($rs), 1);
			$t1 = $rs[0];
			$this->assertEqual($t1->id, 2);
			$this->assertEqual($t1->task, "some activity");
			$this->assertEqual($t1->activity_id, 5);
		}

	}

?>
