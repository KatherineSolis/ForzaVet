<template>
  <el-card v-if="user.nombre_cliente">
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Datos del paciente" name="first">
        <div class="user-activity">
          <div class="dndList" style="padding:20px;">
            <div style="width:50%;" class="dndList-list">
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Historial Clínico</span>
                <span style="padding-left:10px;display:block; color:#566573;">Numero</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Especie</span>
                <span style="padding-left:10px;display:block; color:#566573;">{{ user.specie }}</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Raza</span>
                <span style="padding-left:10px;display:block; color:#566573;">{{ user.breed }}</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">¿Está castrado?</span>
                <span style="padding-left:10px;display:block; color:#566573;">No</span>
              </div>
            </div>
            <div style="width:40%;" class="dndList-list">

              <div class="dndList-list">
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Edad</span>
                  <span style="padding-left:10px;display:block;color:#566573;">{{ user.age }}</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Peso</span>
                  <span style="padding-left:10px;display:block;color:#566573;">Numero</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Color</span>
                  <span style="padding-left:10px;display:block;color:#566573;">Numero</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Nivel de agresividad (0 a 5)</span>
                  <span style="padding-left:10px;display:block;color:#566573;">3</span>
                </div>
              </div>
              <br><br>

            </div>
          </div>

        </div>
      </el-tab-pane>
      <el-tab-pane label="Historial Clínico" name="second">
        <div class="user-activity">
          <div slot="header" class="clearfix">

            <span>Resultados</span>

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/servicio/nuevo"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <br>
          <el-table
            :key="tableKey"
            v-loading="listLoading"
            :data="list"
            border
            fit
            highlight-current-row
            style="width: 100%"
            @sort-change="sortChange"
          >

            <el-table-column
              label="Fecha"
              prop="document_type"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_type }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Motivo"
              prop="document_number"
              align="center"
              min-width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_number }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Veterinario"
              prop="name"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Acciones" align="center" width="250" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
              </template>
            </el-table-column>

          </el-table>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Vacunas" name="third">
        <div class="block">
          <div slot="header" class="clearfix">

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/servicio/vacuna"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <el-timeline>
            <el-timeline-item timestamp="2019/4/17" placement="top">
              <el-card>
                <h4>Nombre: Rabia</h4>
                <p>1 ml</p>
              </el-card>
            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/18" placement="top">
              <el-card>
                <h4>Nombre: nombre de la vacuna</h4>
                <p>Primera dosis</p>
                <p>50kg - 1 ml</p>
              </el-card>

            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/19" placement="top">
              <el-card>
                <h4>Nombre: nombre de la vacuna</h4>
                <p>Primera dosis</p>
                <p>50kg - 1 ml</p>
              </el-card>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Antiparasitarios" name="fourth">
        <div class="block">
          <div slot="header" class="clearfix">

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/servicio/antidesparasitario"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <el-timeline>
            <el-timeline-item timestamp="2019/4/17" placement="top">
              <el-card>
                <h4>Nombre: Rabia</h4>
                <p>1 ml</p>
              </el-card>
            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/18" placement="top">
              <el-card>
                <h4>Nombre: nombre de la vacuna</h4>
                <p>Primera dosis</p>
                <p>50kg - 1 ml</p>
              </el-card>

            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/19" placement="top">
              <el-card>
                <h4>Nombre: nombre de la vacuna</h4>
                <p>Primera dosis</p>
                <p>50kg - 1 ml</p>
              </el-card>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Archivos" name="fifth">
        <div class="user-activity">
          <div class="post">
            <div class="user-block">
              <img
                class="img-circle"
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDkaQO69Fro8SZLTVZQ75JH2R0T-sn5yIA_lKGwvvgQ0R0BoQtUQ"
                alt="user image"
              >
              <span class="username text-muted">
                <a href="#">Iron Man</a>
                <a href="#" class="pull-right btn-box-tool">
                  <i class="fa fa-times" />
                </a>
              </span>
              <span class="description">Shared publicly - 7:30 PM today</span>
            </div>
            <p>
              Lorem ipsum represents a long-held tradition for designers,
              typographers and the like. Some people hate it and argue for
              its demise, but others ignore the hate as they create awesome
              tools to help create filler text for everyone from bacon lovers
              to Charlie Sheen fans.
            </p>
            <ul class="list-inline">
              <li>
                <a href="#" class="link-black text-sm">
                  <i class="el-icon-share" /> Share
                </a>
              </li>
              <li>
                <a href="#" class="link-black text-sm">
                  <svg-icon icon-class="like" />Like
                </a>
              </li>
              <li class="pull-right">
                <a href="#" class="link-black text-sm">
                  <svg-icon icon-class="comment" />Comments
                  (5)
                </a>
              </li>
            </ul>
            <el-input placeholder="Type a comment" />
          </div>
          <div class="post">
            <div class="user-block">
              <img
                class="img-circle"
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMMN-8f9CQQ3MKJpboBJIqaiJ2Wus2Tf4w_vx9STtalxrY3qGJ"
                alt="user image"
              >
              <span class="username text-muted">
                <a href="#">Captain American</a>
                <a href="#" class="pull-right btn-box-tool">
                  <i class="fa fa-times" />
                </a>
              </span>
              <span class="description">Sent you a message - yesterday</span>
            </div>
            <p>
              Lorem ipsum represents a long-held tradition for designers,
              typographers and the like. Some people hate it and argue for
              its demise, but others ignore the hate as they create awesome
              tools to help create filler text for everyone from bacon lovers
              to Charlie Sheen fans.
            </p>
            <el-input placeholder="Response">
              <el-button slot="append">
                Send
              </el-button>
            </el-input>
          </div>
          <div class="post">
            <div class="user-block">
              <img
                class="img-circle img-bordered-sm"
                src="https://cdn3.iconfinder.com/data/icons/movies-3/32/daredevil-superhero-marvel-comics-mutant-avatar-512.png"
                alt="User Image"
              >
              <span class="username">
                <a href="#">Daredevil</a>
                <a href="#" class="pull-right btn-box-tool">
                  <i class="fa fa-times" />
                </a>
              </span>
              <span class="description">Posted 4 photos - 2 days ago</span>
            </div>
            <div class="user-images">
              <el-carousel :interval="6000" type="card" height="200px">
                <el-carousel-item v-for="item in carouselImages" :key="item">
                  <img :src="item" class="image">
                </el-carousel-item>
              </el-carousel>
            </div>
            <ul class="list-inline">
              <li>
                <a href="#" class="link-black text-sm">
                  <i class="el-icon-share" /> Share
                </a>
              </li>
              <li>
                <a href="#" class="link-black text-sm">
                  <svg-icon icon-class="like" />Like
                </a>
              </li>
              <li class="pull-right">
                <a href="#" class="link-black text-sm">
                  <svg-icon icon-class="comment" />Comments
                  (5)
                </a>
              </li>
            </ul>
            <el-input placeholder="Type a comment" />
          </div>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Estética y baños" name="sixth">
        <div class="user-activity">
          <div slot="header" class="clearfix">
            <span>Resultados</span>

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/servicio/crear"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <br>
          <el-table
            :key="tableKey"
            v-loading="listLoading"
            :data="list"
            border
            fit
            highlight-current-row
            style="width: 100%"
            @sort-change="sortChange"
          >

            <el-table-column
              label="Paciente"
              prop="document_type"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_type }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Tipo"
              prop="document_number"
              align="center"
              min-width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_number }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Fecha"
              prop="name"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Acciones" align="center" width="250" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
              </template>
            </el-table-column>

          </el-table>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
const userResource = new Resource('users');

export default {
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      activeActivity: 'first',
      carouselImages: [
        'https://cdn.laravue.dev/photo1.png',
        'https://cdn.laravue.dev/photo2.png',
        'https://cdn.laravue.dev/photo3.jpg',
        'https://cdn.laravue.dev/photo4.jpg',
      ],
      updating: false,
    };
  },
  methods: {
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    onSubmit() {
      this.updating = true;
      userResource
        .update(this.user.id, this.user)
        .then(response => {
          this.updating = false;
          this.$message({
            message: 'User information has been updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-activity {
  .user-block {
    .username, .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .user-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover, &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
}
.dndList {
  background: #fff;
  padding-bottom: 40px;
  &:after {
    content: "";
    display: table;
    clear: both;
  }
  .dndList-list {
    float: left;

    &:first-of-type {
      margin-right: 2%;
    }
    .dragArea {
      margin-top: 15px;
      min-height: 50px;
      padding-bottom: 30px;
    }
  }
}
</style>
