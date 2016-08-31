<?php
// module/Feedback/src/Feedback/Model/FeedbackTable.php:
namespace Feedback\Model;

use Zend\Db\TableGateway\TableGateway;

class FeedbackTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getFeedback($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveFeedback(Feedback $feedback)
    {
        $data = array(
            'artist' => $feedback->artist,
            'title'  => $feedback->title,
        );

        $id = (int)$feedback->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFeedback($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteFeedback($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
