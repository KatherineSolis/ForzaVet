import request from '@/utils/request';

export function fetchList() {
  return request({
    url: '/citas',
    method: 'get',
  });
}

export function createCita(data) {
  return request({
    url: '/cita/create',
    method: 'post',
    data,
  });
}

export function updateCita(data) {
  return request({
    url: '/cita/update/' + data.id,
    method: 'post',
    data,
  });
}

export function ListPersonal() {
  return request({
    url: '/cita/personals',
    method: 'get',
  });
}

export function ListClient() {
  return request({
    url: '/cita/client',
    method: 'get',
  });
}

export function ListPet(query) {
  return request({
    url: '/cita/pet',
    method: 'get',
    params: query,
  });
}

export function ListVaccine() {
  return request({
    url: '/cita/vaccine',
    method: 'get',
  });
}

export function ListAntiparasitic() {
  return request({
    url: '/cita/antiparasitic',
    method: 'get',
  });
}
