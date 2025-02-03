// src/app/types/apex-states.d.ts
import { ApexStates } from 'ng-apexcharts';

export interface CustomApexStates extends ApexStates {
  normal?: {
    filter: { type: string; value: number };
  };
  hover?: {
    filter: { type: string; value: number };
  };
  active?: {
    allowMultipleDataPointsSelection: boolean;
    filter: { type: string; value: number };
  };
}
