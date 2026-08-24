<?php

namespace App\Models;

use App\Core\Model;
use PDOException;
use RuntimeException;

final class Booking extends Model
{
    protected static string $table = 'agendamentos';

    public static function criar(int $userId, int $aulaId, int $aparelhoId): void
    {
        static::beginTransaction();

        try {
            $user = User::lockForUpdate($userId);

            if (!$user) {
                throw new RuntimeException('Usuario nao encontrado.');
            }

            if (!User::fichasAindaValidas($user)) {
                throw new RuntimeException($user['fichas'] > 0
                    ? 'Suas fichas expiraram em ' . date('d/m/Y', strtotime($user['validade_fichas'])) . '.'
                    : 'Voce nao possui fichas disponiveis.');
            }

            $ocupado = static::query(
                'SELECT id FROM agendamentos WHERE aula_id = ? AND aparelho_id = ?',
                [$aulaId, $aparelhoId]
            )->fetch();

            if ($ocupado) {
                throw new RuntimeException('Este aparelho acabou de ser ocupado por outro aluno. Escolha outro.');
            }

            User::debitarFicha($userId);

            static::insert([
                'usuario_id' => $userId,
                'aula_id' => $aulaId,
                'aparelho_id' => $aparelhoId,
                'data_agendamento' => date('Y-m-d H:i:s'),
            ]);

            static::commit();
        } catch (PDOException $exception) {
            static::rollBack();

            if ($exception->getCode() === '23000') {
                throw new RuntimeException('Este aparelho acabou de ser ocupado por outro aluno. Escolha outro.');
            }

            throw new RuntimeException('Nao foi possivel concluir o agendamento. Tente novamente.');
        } catch (RuntimeException $exception) {
            static::rollBack();
            throw $exception;
        }
    }

    public static function cancelar(int $agendamentoId, int $userId): bool
    {
        static::beginTransaction();

        $statement = static::query(
            'DELETE FROM agendamentos WHERE id = ? AND usuario_id = ?',
            [$agendamentoId, $userId]
        );

        $removido = $statement->rowCount() === 1;

        if ($removido) {
            User::creditarFicha($userId);
        }

        static::commit();

        return $removido;
    }

    public static function detalhesParaCancelamento(int $agendamentoId, int $userId): ?array
    {
        $sql = '
            SELECT ag.*, a.data_aula, a.horario
            FROM agendamentos ag
            JOIN aulas a ON ag.aula_id = a.id
            WHERE ag.id = ? AND ag.usuario_id = ?
        ';

        return static::query($sql, [$agendamentoId, $userId])->fetch() ?: null;
    }

    public static function podeCancelar(array $agendamento): bool
    {
        $horario = strtotime($agendamento['data_aula'] . ' ' . $agendamento['horario']);

        return $horario > (time() + 3600);
    }

    public static function daSemana(int $userId, string $inicio, string $fim): array
    {
        $sql = '
            SELECT a.data_aula, ag.id AS agendamento_id, a.modalidade, a.professor, a.horario
            FROM agendamentos ag
            INNER JOIN aulas a ON ag.aula_id = a.id
            WHERE ag.usuario_id = ? AND a.data_aula BETWEEN ? AND ?
            ORDER BY a.horario ASC
        ';

        return static::query($sql, [$userId, $inicio, $fim])->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_ASSOC);
    }

    public static function totalFuturasParaUsuario(array $aulasComFlag): int
    {
        $total = 0;

        foreach ($aulasComFlag as $aula) {
            if ($aula['ja_agendado'] > 0) {
                $total++;
            }
        }

        return $total;
    }

    public static function usuariosAgendados(int $aulaId, int $excluirUsuarioId): array
    {
        return static::query(
            'SELECT usuario_id FROM agendamentos WHERE aula_id = ? AND usuario_id != ?',
            [$aulaId, $excluirUsuarioId]
        )->fetchAll(\PDO::FETCH_COLUMN);
    }

    public static function removerTodosDaAula(int $aulaId): void
    {
        static::query('DELETE FROM agendamentos WHERE aula_id = ?', [$aulaId]);
    }

    public static function alternarManutencao(int $aulaId, int $aparelhoId, int $usuarioManutencaoId): void
    {
        $existente = static::query(
            'SELECT id, usuario_id FROM agendamentos WHERE aula_id = ? AND aparelho_id = ?',
            [$aulaId, $aparelhoId]
        )->fetch();

        if ($existente) {
            if ((int) $existente['usuario_id'] === $usuarioManutencaoId) {
                static::delete($existente['id']);
            }
            return;
        }

        static::insert([
            'usuario_id' => $usuarioManutencaoId,
            'aula_id' => $aulaId,
            'aparelho_id' => $aparelhoId,
            'data_agendamento' => date('Y-m-d H:i:s'),
        ]);
    }
}
