import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/citas',
    method: 'get',
    params: query,
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

export function getAppointment(data) {
  return request({
    url: '/cita/consultar/' + data,
    method: 'post',
    data,
  });
}

export function getClinic(data) {
  return request({
    url: '/cita/history/' + data,
    method: 'post',
    data,
  });
}

export function fetchListPet() {
  return request({
    url: '/cita/list/pet',
    method: 'get',
  });
}
