import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { Routes, RouterModule } from '@angular/router';
import { HttpModule } from '@angular/http';

// providers
import { GithubService } from '../services/api/github-service';

// pages
import { Home } from 'pages/home/home'
import { Login } from 'pages/login/login'

const appRoutes: Routes = [
  { path: '', component: Home },
  { path: 'login', component: Login }
];

@NgModule({
  declarations: [
    AppComponent,
    // Pages
    Home,
    Login
  ],
  imports: [
    RouterModule.forRoot(appRoutes),
    BrowserModule,
    HttpModule
  ],
  providers: [
    GithubService
  ],
  bootstrap: [
    AppComponent
  ]
})
export class AppModule { }
