<section class="col-md-12">
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
    </div>
    <?php endif;?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="<?=self::link('alunos')?>" class="btn btn-default pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
            <h4><i class="fa fa-search fa-lg" aria-hidden="true"></i> Pesquisa de Fichas</h4>
        </div>
        <div class="panel-body">
            <form action="<?=self::link('pesquisar');?>" method="post">
                <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                <div class="input-group">
                    <input type="text" class="form-control input-lg" minlength="3" name="search" placeholder="Nome do Aluno" required autofocus>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-lg" type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>
                    </span>
                </div>
            </form>
            <?php if (!is_null($count)):?>
                <p>Total de registros encontrados: <strong><?=$count?></strong></p>
            <?php endif;?>
        </div>     
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Pai</th>
                    <th>Mãe</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $tupla):
                ?>
                <tr>
                    <td class="ficha-table"><?=sprintf('%04d',$tupla->ficha)?></td>
                    <td><?=$tupla->nome?></td>
                    <td><?=date('d/m/Y', strtotime($tupla->data_nascimento))?></td>
                    <td><?=$tupla->pai? $tupla->pai: '-' ?></td>
                    <td><?=$tupla->mae?></td>
                    <td>                            
                        <div class="btn-group" role="group">
                            <a href="<?=self::link('alunos/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                            <a href="<?=self::link('alunos/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</section>