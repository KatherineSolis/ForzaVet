import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/histories',
    method: 'get',
    params: query,
  });
}

export function createHistory(data) {
  return request({
    url: '/history/create',
    method: 'post',
    data,
  });
}

export function updateHistory(data) {
  return request({
    url: '/history/update/' + data.id,
    method: 'post',
    data,
  });
}

export function peluqueriaList(query) {
  return request({
    url: '/peluquerias',
    method: 'get',
    params: query,
  });
}

export function consultaList(query) {
  return request({
    url: '/consultas',
    method: 'get',
    params: query,
  });
}

export function peluqueriaCreate(data) {
  return request({
    url: '/peluqueria/create/' + data,
    method: 'post',
    data,
  });
}
