// Import and re-export all types from individual stores
import type {
  FilterFieldData,
  FilterField,
  FilterGroup,
  FilterGroupLogic,
  FilterItem,
  FiltersState,
} from '../stores/filtersStore';

import type {
  RuleFieldData,
  RuleField,
  RuleGroup,
  RuleGroupLogic,
  RuleConditionItem,
  RuleAction,
  Rule,
} from '../stores/rulesStore';

// Re-export all types
export type {
  FilterFieldData,
  FilterField,
  FilterGroup,
  FilterGroupLogic,
  FilterItem,
  FiltersState,
  RuleFieldData,
  RuleField,
  RuleGroup,
  RuleGroupLogic,
  RuleConditionItem,
  RuleAction,
  Rule,
};

// Shared types used by both stores
export interface AttributeGroup {
  [groupName: string]: {
    [attribute: string]: string;
  };
}

export interface ConditionOption {
  value: string;
  label: string;
  group?: string;
}

export interface ActionOption {
  value: string;
  label: string;
}

// Common field types
export type FieldType = 'field' | 'logic';
export type LogicOperator = 'and' | 'or';
export type SectionType = 'include' | 'exclude';

// API response types
export interface ApiResponse<T> {
  data: T;
  success: boolean;
  message?: string;
}

export interface FiltersApiResponse {
  filters?: FiltersState;
  attributes?: AttributeGroup;
  filterConditions?: ConditionOption[];
}

export interface RulesApiResponse {
  rules?: Rule[];
  attributes?: AttributeGroup;
  thenAttributes?: AttributeGroup;
  ruleConditions?: ConditionOption[];
  ruleActions?: ActionOption[];
}

// Component prop types
export interface FilterItemProps {
  item: FilterField;
  groupId: string;
  fieldIndex: number;
  section: SectionType;
  groupIndex: number;
}

export interface FilterGroupProps {
  group: FilterItem;
  groupIndex: number;
  section: SectionType;
}

export interface FilterSectionProps {
  type: SectionType;
}

export interface RuleItemProps {
  item: RuleField;
  groupId: string;
  fieldIndex: number;
  ruleId: string;
  groupIndex: number;
}

export interface RuleGroupProps {
  group: RuleConditionItem;
  groupIndex: number;
  ruleId: string;
}

// Utility types
export type DeepPartial<T> = {
  [P in keyof T]?: T[P] extends object ? DeepPartial<T[P]> : T[P];
};

export type Nullable<T> = T | null;
export type Optional<T> = T | undefined;
