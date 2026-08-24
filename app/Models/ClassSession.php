<?php

namespace App\Models;

use App\Core\Model;

final class ClassSession extends Model
{
    protected static string $table = 'aulas';

    public static function proximasParaUsuario(int $userId): array
    {
        $sql = "
            SELECT a.*,
                (a.vagas_totais - (SELECT COUNT(*) FROM agendamentos ag WHERE ag.aula_id = a.id)) AS vagas_reais,
                (SELECT COUNT(*) FROM agendamentos ag WHERE ag.aula_id = a.id AND ag.usuario_id = ?) AS ja_agendado,
                (SELECT aparelho_id FROM agendamentos ag WHERE ag.aula_id = a.id AND ag.usuario_id = ? LIMIT 1) AS meu_aparelho
            FROM aulas a
            WHERE (a.data_aula > CURDATE())
               OR (a.data_aula = CURDATE() AND ADDTIME(a.horario, '00:45:00') > CURTIME())
            ORDER BY a.data_aula ASC, a.horario ASC
        ";

        return static::query($sql, [$userId, $userId])->fetchAll();
    }

    public static function aparelhosOcupados(): array
    {
        $stmt = static::query('SELECT aula_id, aparelho_id FROM agendamentos WHERE aparelho_id IS NOT NULL');

        return $stmt->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_COLUMN);
    }

    public static function comFiltros(?string $data, ?string $modalidade): array
    {
        $where = [];
        $bindings = [];

        if ($data) {
            $where[] = 'a.data_aula = ?';
            $bindings[] = $data;
        }

        if ($modalidade) {
            $where[] = 'a.modalidade = ?';
            $bindings[] = $modalidade;
        }

        $sqlWhere = $where ? ' WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT a.*,
                COUNT(CASE WHEN ag.usuario_id != 999 THEN ag.id END) AS total_agendados,
                COUNT(CASE WHEN ag.usuario_id = 999 THEN ag.id END) AS total_inativos
            FROM aulas a
            LEFT JOIN agendamentos ag ON a.id = ag.aula_id
            $sqlWhere
            GROUP BY a.id
            ORDER BY a.data_aula DESC, a.horario DESC
        ";

        return static::query($sql, $bindings)->fetchAll();
    }

    public static function ocupantes(int $aulaId): array
    {
        $sql = 'SELECT ag.*, u.nome FROM agendamentos ag LEFT JOIN usuarios u ON ag.usuario_id = u.id WHERE ag.aula_id = ?';

        return static::query($sql, [$aulaId])->fetchAll();
    }
}
