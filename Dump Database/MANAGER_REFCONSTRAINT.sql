--------------------------------------------------------
--  Ref Constraints for Table MANAGER
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."MANAGER" ADD CONSTRAINT "MANAGER_FK1" FOREIGN KEY ("COMPANY_ID")
	  REFERENCES "SYSTEM"."COMPANY" ("ID") ON DELETE CASCADE ENABLE;
