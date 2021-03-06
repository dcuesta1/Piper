import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {IndexComponent} from './_layout/index/index.component';
import {DashboardComponent} from './dashboard/dashboard.component';
import {TestComponent} from './dashboard/test/test.component';
import {AuthGuard} from './_guards/auth.guard';


const routes: Routes = [
  {
    path: '',
    component: IndexComponent,
    canActivate: [AuthGuard],
    children: [
      {
        path: '',
        redirectTo: '/dashboard',
        pathMatch: 'full'
      },
      {
        path: 'dashboard',
        component: DashboardComponent,
        children: [
          {
            path: 'test',
            component: TestComponent
          }
        ]
      }
    ]}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
