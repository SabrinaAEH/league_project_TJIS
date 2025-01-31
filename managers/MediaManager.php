<?php

namespace App\Managers;

use PDO;
use App\Models\MediaModel;

class MediaManager extends AbstractManager
{
    public function findMediaById(int $id): ?MediaModel
    {
        $query = $this->db->prepare("SELECT * FROM media WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new MediaModel($data['url'], $data['alt'], $data['id']);
    }
}
?>
